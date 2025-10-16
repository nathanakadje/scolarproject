<?php

namespace App\Livewire\Professor;

use Illuminate\Validation\Rule;
use App\Models\Teacher;
use App\Models\Classe;
use App\Models\Subject;
use App\Models\Evaluation;
use App\Models\Grade;
use App\Models\Student;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

#[Layout('layouts.professor-layout')]
class GradeManagement extends Component
{
    public $teacher;
    public $evaluationStatus;
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
    public $coefficient = 1;
    public $term = '1';
    public $classId;
    public $subjectId;
    public $teacherId;
    public $academicYearId;

    // Grades
    public $grades = [];
    public $editingGradeId = null;

    public function mount()
    {
        $this->teacher = Teacher::where('user_id', auth()->id())->first();

        if (!$this->teacher) {
            session()->flash('error', 'Profil professeur non trouvé');
            return redirect()->route('professor.dashboard');
        }

        $this->evaluationDate = now()->format('Y-m-d');
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

        return Evaluation::with(['classe.students', 'grades'])
            ->find($this->selectedEvaluationId);
    }

    #[Computed]
    public function students()
    {
        if (!$this->selectedEvaluation)
            return collect();

        return $this->selectedEvaluation->classe->students()
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
        $this->evaluationTitle = '';
        $this->evaluationDescription = '';
        $this->evaluationType = 'devoir';
        $this->evaluationStatus = 'draft';
        $this->evaluationDate = now()->format('Y-m-d');
        $this->maxScore = 20;
        $this->coefficient = 1;
        $this->term = '1';
    }

    // ------------------------------------------------
    // ✅ Validation Rules
    // ------------------------------------------------
    protected function rules()
    {
        return [
            'evaluationTitle' => 'required|string|max:255',
            'evaluationType' => ['required', Rule::in(['quiz', 'test', 'exam', 'assignment'])],
            'evaluationStatus' => ['required', Rule::in(['draft', 'published', 'completed'])],
            'evaluationDate' => 'required|date|after_or_equal:today',
            'maxScore' => 'required|numeric|min:10|max:50',
            'classId' => ['required', Rule::exists('classes', 'id')],
            'subjectId' => ['required', Rule::exists('subjects', 'id')],
            'teacherId' => ['required', Rule::exists('users', 'id')],
            'academicYearId' => ['required', Rule::exists('academic_years', 'id')],
        ];
    }

    // ------------------------------------------------
    // ✅ Messages personnalisés
    // ------------------------------------------------
    protected function messages()
    {
        return [
            'evaluationTitle.required' => 'Le titre de l\'évaluation est obligatoire.',
            'evaluationStatus.required' => 'Le Status de est obligatoire.',
            'evaluationTitle.max' => 'Le titre ne doit pas dépasser 255 caractères.',
            'evaluationType.required' => 'Veuillez sélectionner un type d\'évaluation.',
            'evaluationType.in' => 'Le type d\'évaluation sélectionné est invalide.',
            'evaluationDate.required' => 'La date de l\'évaluation est obligatoire.',
            'evaluationDate.after_or_equal' => 'La date ne peut pas être dans le passé.',
            'maxScore.required' => 'La note maximale est obligatoire.',
            'maxScore.min' => 'La note maximale doit être au moins de 10.',
            'maxScore.max' => 'La note maximale ne peut pas dépasser 50.',
            'classId.required' => 'La classe est obligatoire.',
            'classId.exists' => 'La classe sélectionnée n\'existe pas.',
            'subjectId.required' => 'La matière est obligatoire.',
            'subjectId.exists' => 'La matière sélectionnée n\'existe pas.',
            'teacherId.required' => 'Le professeur est obligatoire.',
            'teacherId.exists' => 'Le professeur sélectionné n\'existe pas.',
            'academicYearId.required' => 'L\'année académique est obligatoire.',
            'academicYearId.exists' => 'L\'année académique sélectionnée n\'existe pas.',
        ];
    }

    // ------------------------------------------------
    // ✅ Alias des attributs (affichage dans erreurs)
    // ------------------------------------------------
    protected function validationAttributes()
    {
        return [
            'evaluationTitle' => 'titre',
            'evaluationType' => 'type d\'évaluation',
            'evaluationStatus' => 'status',
            'evaluationDate' => 'date',
            'maxScore' => 'note maximale',
            'classId' => 'classe',
            'subjectId' => 'matière',
            'teacherId' => 'professeur',
            'academicYearId' => 'année académique',
        ];
    }

    // ------------------------------------------------
    // ✅ Méthode d’enregistrement
    // ------------------------------------------------
    public function save()
    {
        $this->validate();

        try {
            Evaluation::create([
                'name' => $this->evaluationTitle,
                'subject_id' => $this->subjectId,
                'class_id' => $this->classId,
                'academic_year_id' => $this->academicYearId,
                'teacher_id' => $this->teacherId,
                'type' => $this->evaluationType,
                'date' => $this->evaluationDate,
                'max_score' => $this->maxScore,
                'description' => $this->evaluationDescription,
                'status' => $this->evaluationStatus,
            ]);


            $this->dispatch('evaluation-created');
            session()->flash('success', 'Évaluation créée avec succès!');

        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la création: ' . $e->getMessage());
        }
    }


    public function saveGrade($studentId)
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

        $this->loadGrades();

        $this->dispatch('grade-saved', [
            'message' => 'Note enregistrée avec succès'
        ]);
    }

    public function saveAllGrades()
    {
        $savedCount = 0;

        foreach ($this->grades as $studentId => $gradeData) {
            if ($gradeData['score'] !== '') {
                $this->saveGrade($studentId);
                $savedCount++;
            }
        }

        session()->flash('success', "{$savedCount} note(s) enregistrée(s) avec succès");
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