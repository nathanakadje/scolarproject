<?php

namespace App\Livewire\Professor;

use App\Models\Teacher;
use App\Models\ClassModel;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Attendance;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

#[Layout('layouts.professor-layout')]
class TeacherClassManagement extends Component
{
    public $teacher;
    public $selectedClassId = null;
    public $selectedSubjectId = null;
    public $selectedStudentId = null;
    public $showStudentModal = false;
    public $attendanceDate;
    public $attendanceStatus = [];

    // Filters
    public $searchStudent = '';
    public $statusFilter = 'all';

    public function mount()
    {
        // Get current teacher
        $this->teacher = Teacher::where('user_id', auth()->id())->first();

        if (!$this->teacher) {
            session()->flash('error', 'Profil professeur non trouvé');
            return redirect()->route('professor.dashboard');
        }

        $this->attendanceDate = today()->format('Y-m-d');
    }

    #[Computed]
    public function classes()
    {
        return $this->teacher->getCurrentClasses();
    }

    #[Computed]
    public function selectedClass()
    {
        if (!$this->selectedClassId)
            return null;

        return ClassModel::with([
            'academicLevel',
            'academicYear',
            'students' => function ($query) {
                $query->where('enrollments.status', 'active')
                    ->orderBy('last_name')
                    ->orderBy('first_name');
            }
        ])->find($this->selectedClassId);
    }

    #[Computed]
    public function subjects()
    {
        if (!$this->selectedClassId)
            return collect();

        return $this->teacher->getSubjectsForClass($this->selectedClassId);
    }

    #[Computed]
    public function students()
    {
        if (!$this->selectedClass)
            return collect();

        $students = $this->selectedClass->students()
            ->when($this->searchStudent, function ($query) {
                $query->where(function ($q) {
                    $q->where('first_name', 'like', "%{$this->searchStudent}%")
                        ->orWhere('last_name', 'like', "%{$this->searchStudent}%")
                        ->orWhere('student_number', 'like', "%{$this->searchStudent}%");
                });
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->with([
                'attendances' => function ($query) {
                    $query->where('date', $this->attendanceDate);
                }
            ])
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        // Load today's attendance
        foreach ($students as $student) {
            $attendance = $student->attendances->first();
            $this->attendanceStatus[$student->id] = $attendance ? $attendance->status : null;
        }

        return $students;
    }

    public function selectClass($classId)
    {
        $this->selectedClassId = $classId;
        $this->selectedSubjectId = null;
        $this->searchStudent = '';
        $this->statusFilter = 'all';

        // Reset attendance status
        $this->attendanceStatus = [];
    }

    public function selectSubject($subjectId)
    {
        $this->selectedSubjectId = $subjectId;
    }

    public function viewStudentDetails($studentId)
    {
        $this->selectedStudentId = $studentId;
        $this->showStudentModal = true;
    }

    public function closeStudentModal()
    {
        $this->showStudentModal = false;
        $this->selectedStudentId = null;
    }

    #[Computed]
    public function selectedStudent()
    {
        if (!$this->selectedStudentId)
            return null;

        return Student::with(['classe.level', 'grades.evaluation.subject'])
            ->find($this->selectedStudentId);
    }

    public function markAttendance($studentId, $status)
    {
        // Check if attendance already exists for today
        $attendance = Attendance::where('student_id', $studentId)
            ->where('class_id', $this->selectedClassId)
            ->where('date', $this->attendanceDate)
            ->first();

        if ($attendance) {
            $attendance->update([
                'status' => $status,
                'subject_id' => $this->selectedSubjectId,
            ]);
        } else {
            Attendance::create([
                'student_id' => $studentId,
                'class_id' => $this->selectedClassId,
                'subject_id' => $this->selectedSubjectId,
                'teacher_id' => $this->teacher->id,
                'date' => $this->attendanceDate,
                'time' => now()->format('H:i:s'),
                'status' => $status,
            ]);
        }

        $this->attendanceStatus[$studentId] = $status;

        $this->dispatch('attendance-marked', [
            'message' => 'Présence enregistrée avec succès'
        ]);
    }

    public function markAllPresent()
    {
        if (!$this->selectedClass)
            return;

        foreach ($this->students as $student) {
            $this->markAttendance($student->id, 'present');
        }

        session()->flash('success', 'Tous les élèves ont été marqués présents');
    }

    public function exportAttendance()
    {
        // Logic to export attendance (PDF/Excel)
        session()->flash('info', 'Export en cours de développement');
    }

    public function getClassStatistics()
    {
        if (!$this->selectedClass)
            return [];

        $totalStudents = $this->selectedClass->students()->count();
        $activeStudents = $this->selectedClass->students()->where('enrollments.status', 'active')->count();

        $todayAttendance = Attendance::where('class_id', $this->selectedClassId)
            ->where('date', $this->attendanceDate)
            ->get();

        $present = $todayAttendance->where('status', 'present')->count();
        $absent = $todayAttendance->where('status', 'absent')->count();
        $late = $todayAttendance->where('status', 'late')->count();

        return [
            'total' => $totalStudents,
            'active' => $activeStudents,
            'present_today' => $present,
            'absent_today' => $absent,
            'late_today' => $late,
            'attendance_rate' => $totalStudents > 0 ? round(($present / $totalStudents) * 100, 1) : 0,
        ];
    }

    public function render()
    {
        $stats = $this->getClassStatistics();

        return view('livewire.professor.teacher-class-management', [
            'stats' => $stats,
        ]);
    }
}