<?php

namespace App\Livewire\Professor;

use Livewire\Component;
use App\Models\Teacher;
use App\Models\ClassModel;
use App\Models\Subject;
use App\Models\AcademicYear;
use App\Models\Evaluation;
use App\Models\Grade;
use App\Models\Student;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Traits\HasToastNotifications;

#[Layout('layouts.professor-layout')]
class GradeManagement extends Component
{
    use HasToastNotifications;
    public $name;
    public $subjectId;
    public $classId;
    public $academicYearId;
    public $teacherId;
    public $type = 'devoir';
    public $date;
    public $durationMinutes;
    public $description;
    public $status = 'draft';


    public $teachers;
    public $teacher;
    public $selectedClassId = null;
    public $selectedSubjectId = null;
    public $selectedEvaluationId = null;

    // Evaluation Form
    public $showEvaluationModal = false;
    public $evaluationTitle = '';
    public $evaluationDescription = '';
    public $evaluationType = 'devoir';
    public $evaluationDate;
    public $maxScore = 20;


    // Grades
    public $grades = [];
    public $editingGradeId = null;

    public function mount()
    {
        $this->teacher = Teacher::where('user_id', auth()->id())->first();

        if (!$this->teacher) {
            $this->toasterror('Profil professeur non trouvé');
            return redirect()->route('professor.dashboard');
        }
        $this->teacherId = $this->teacher->id ?? null;
        $this->evaluationDate = today()->format('Y-m-d');
    }

    #[Computed]
    public function classes()
    {

        return $this->teacher->getCurrentClasses();
    }

    #[Computed]
    public function subjects()
    {
        if (!$this->selectedClassId)
            return collect();
        return $this->teacher->getSubjectsForClass($this->selectedClassId);
    }
    #[Computed]
    public function academicYears()
    {
        return AcademicYear::orderBy('start_date', 'desc')->get();
    }


    #[Computed]
    public function evaluations()
    {
        if (!$this->selectedClassId || !$this->selectedSubjectId)
            return collect();

        return Evaluation::where('class_id', $this->selectedClassId)
            ->where('subject_id', $this->selectedSubjectId)
            ->where('teacher_id', $this->teacher->id)
            ->with(['grades.student'])
            ->orderBy('date', 'desc')
            ->get();
    }

    #[Computed]
    public function selectedEvaluation()
    {
        if (!$this->selectedEvaluationId)
            return null;

        return Evaluation::with(['class.students', 'grades'])
            ->find($this->selectedEvaluationId);
    }

    #[Computed]
    public function students()
    {
        if (!$this->selectedEvaluation)
            return collect();

        return $this->selectedEvaluation->class->students()
            ->where('status', 'active')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();
    }

    public function selectClass($classId)
    {
        $this->selectedClassId = $classId;
        $this->selectedSubjectId = null;
        $this->selectedEvaluationId = null;
        $this->resetGrades();
    }

    public function selectSubject($subjectId)
    {
        $this->selectedSubjectId = $subjectId;
        $this->selectedEvaluationId = null;
        $this->resetGrades();
    }

    public function selectEvaluation($evaluationId)
    {
        $this->selectedEvaluationId = $evaluationId;
        $this->loadGrades();
    }


    public function loadGrades()
    {
        if (!$this->selectedEvaluation)
            return;

        $this->grades = [];

        foreach ($this->students as $student) {
            $grade = Grade::where('student_id', $student->id)
                ->where('evaluation_id', $this->selectedEvaluationId)
                ->first();

            $this->grades[$student->id] = [
                'score' => $grade ? $grade->score : '',
                'feedback' => $grade ? $grade->feedback : '',
                'id' => $grade ? $grade->id : null,
            ];
        }
    }

    public function resetGrades()
    {
        $this->grades = [];
        $this->editingGradeId = null;
    }

    public function openEvaluationModal()
    {
        $this->showEvaluationModal = true;
    }

    public function closeEvaluationModal()
    {
        $this->showEvaluationModal = false;
        $this->resetEvaluationForm();
    }

    public function resetEvaluationForm()
    {
        $this->name = '';
        $this->evaluationDescription = '';
        $this->type = 'devoir';
        $this->date = today()->format('Y-m-d');
        $this->maxScore = 20;
    }

    public function createEvaluation()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'subjectId' => 'required|exists:subjects,id',
            'classId' => 'required|exists:classes,id',
            'academicYearId' => 'required|exists:academic_years,id',
            'teacherId' => 'required|exists:teachers,id',
            'type' => 'required|in:quiz,test,exam,assignment',
            'date' => 'required|date',
            'maxScore' => 'required|numeric|min:1',
            'durationMinutes' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'status' => 'required|in:draft,published,completed',
        ]);

        $evaluation = Evaluation::create([
            'name' => $this->name,
            'subject_id' => $this->subjectId,
            'class_id' => $this->classId,
            'academic_year_id' => $this->academicYearId,
            'teacher_id' => $this->teacherId,
            'type' => $this->type,
            'date' => $this->date,
            'max_score' => $this->maxScore,
            'duration_minutes' => $this->durationMinutes,
            'description' => $this->description,
            'status' => $this->status,
        ]);

        $this->selectedEvaluationId = $evaluation->id;
        $this->closeEvaluationModal();
        $this->loadGrades();

        session()->flash('success', 'Évaluation créée avec succès');
    }

    public function saveGrade($studentId, $reload = true)
    {

        $gradeData = $this->grades[$studentId] ?? null;

        if (!$gradeData || $gradeData['score'] === '') {
            return;
        }

        $score = floatval($gradeData['score']);

        if ($score < 0 || $score > $this->selectedEvaluation->max_score) {
            session()->flash('error', "La note doit être entre 0 et {$this->selectedEvaluation->max_score}");
            return;
        }
        try {
            Grade::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'evaluation_id' => $this->selectedEvaluationId,
                ],
                [
                    'score' => $score,
                    'feedback' => $gradeData['feedback'] ?? null,
                    'graded_at' => now(),
                    'graded_by' => $this->teacher->id,
                ]
            );

            if ($reload) {
                $this->loadGrades();
            }
            $this->toastsuccess(" Note enregistrée avec succès");
        } catch (\Exception $e) {
            $this->toasterror(" Une erreur est survenue lors de l'enregistrement: ");

        }
        // session()->flash('success', " note enregistrée(s) avec succès");
    }


    public function saveAllGrades()
    {
        try {
            $savedCount = 0;

            foreach ($this->grades as $studentId => $gradeData) {
                if ($gradeData['score'] !== '') {
                    // ⚠️ Appel de saveGrade SANS loadGrades automatique
                    $this->saveGrade($studentId, $reload = false);
                    $savedCount++;
                }
            }
            $this->loadGrades();

            $this->toastsuccess(" {$savedCount} note(s) enregistrée(s) avec succès");
        } catch (\Exception $e) {
            $this->toasterror(" Une erreur est survenue lors de l'enregistrement: ");

        }
        // session()->flash('success', "{$savedCount} note(s) enregistrée(s) avec succès");
    }

    public function publishEvaluation()
    {
        if (!$this->selectedEvaluation)
            return;

        $this->selectedEvaluation->update(['is_published' => true]);

        session()->flash('success', 'Évaluation publiée. Les élèves peuvent maintenant voir leurs notes.');
    }

    public function deleteEvaluation($evaluationId)
    {
        $evaluation = Evaluation::find($evaluationId);

        if ($evaluation && $evaluation->teacher_id === $this->teacher->id) {
            $evaluation->delete();
            $this->selectedEvaluationId = null;
            $this->resetGrades();
            session()->flash('success', 'Évaluation supprimée avec succès');
        }
    }

    public function getEvaluationStats()
    {
        if (!$this->selectedEvaluation)
            return [];

        $grades = $this->selectedEvaluation->grades()
            ->whereNotNull('score')
            ->pluck('score');

        if ($grades->isEmpty()) {
            return [
                'total_students' => $this->selectedEvaluation->getTotalStudents(),
                'graded' => 0,
                'average' => 0,
                'min' => 0,
                'max' => 0,
            ];
        }

        return [
            'total_students' => $this->selectedEvaluation->getTotalStudents(),
            'graded' => $grades->count(),
            'average' => round($grades->avg(), 2),
            'min' => $grades->min(),
            'max' => $grades->max(),
        ];
    }

    public function render()
    {
        $stats = $this->getEvaluationStats();

        return view('livewire.professor.grade-management', [
            'stats' => $stats,
        ]);
    }
}