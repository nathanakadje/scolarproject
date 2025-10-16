<?php

namespace App\Livewire\Professor;

use App\Models\Teacher;
use App\Models\Student;
use App\Models\Classe;
use App\Models\Subject;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

#[Layout('layouts.professor-layout')]
class MyStudents extends Component
{
    use WithPagination;

    public $teacher;

    // Filters
    public $searchTerm = '';
    public $selectedClassId = null;
    public $selectedSubjectId = null;
    public $statusFilter = 'active';
    public $genderFilter = 'all';
    public $sortBy = 'last_name';
    public $sortDirection = 'asc';

    // Modal
    public $showStudentModal = false;
    public $selectedStudentId = null;

    // Stats view
    public $viewMode = 'grid'; // grid or table

    public function mount()
    {
        $this->teacher = Teacher::where('user_id', auth()->id())->first();

        if (!$this->teacher) {
            session()->flash('error', 'Profil professeur non trouvé');
            return redirect()->route('professor.dashboard');
        }
    }

    #[Computed]
    public function classes()
    {
        return $this->teacher->getCurrentClasses();
    }

    #[Computed]
    public function subjects()
    {
        if (!$this->selectedClassId) {
            return $this->teacher->subjects()->distinct()->get();
        }

        return $this->teacher->getSubjectsForClass($this->selectedClassId);
    }

    #[Computed]
    public function students()
    {
        $query = Student::query()
            ->whereIn('class_id', $this->teacher->getCurrentClasses()->pluck('id'))
            ->with(['classe.academicLevel', 'grades.evaluation', 'attendances']);

        // Search filter
        if ($this->searchTerm) {
            $query->where(function ($q) {
                $q->where('first_name', 'ilike', "%{$this->searchTerm}%")
                    ->orWhere('last_name', 'ilike', "%{$this->searchTerm}%")
                    ->orWhere('student_number', 'like', "%{$this->searchTerm}%")
                    ->orWhere('email', 'ilike', "%{$this->searchTerm}%");
            });
        }

        // Class filter
        if ($this->selectedClassId) {
            $query->where('class_id', $this->selectedClassId);
        }

        // Status filter
        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        // Gender filter
        if ($this->genderFilter !== 'all') {
            $query->where('gender', $this->genderFilter);
        }

        // Sorting
        $query->orderBy($this->sortBy, $this->sortDirection);

        return $query->paginate(20);
    }

    #[Computed]
    public function selectedStudent()
    {
        if (!$this->selectedStudentId)
            return null;

        return Student::with([
            'classe.academicLevel',
            'grades.evaluation.subject',
            'attendances' => function ($query) {
                $query->orderBy('date', 'desc')->limit(30);
            }
        ])->find($this->selectedStudentId);
    }

    public function selectClass($classId)
    {
        $this->selectedClassId = $classId;
        $this->resetPage();
    }

    public function selectSubject($subjectId)
    {
        $this->selectedSubjectId = $subjectId;
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->searchTerm = '';
        $this->selectedClassId = null;
        $this->selectedSubjectId = null;
        $this->statusFilter = 'active';
        $this->genderFilter = 'all';
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function viewStudent($studentId)
    {
        $this->selectedStudentId = $studentId;
        $this->showStudentModal = true;
    }

    public function closeStudentModal()
    {
        $this->showStudentModal = false;
        $this->selectedStudentId = null;
    }

    public function toggleViewMode()
    {
        $this->viewMode = $this->viewMode === 'grid' ? 'table' : 'grid';
    }

    public function getGlobalStats()
    {
        $allStudents = Student::whereIn('class_id', $this->teacher->getCurrentClasses()->pluck('id'))
            ->where('status', 'active')
            ->get();

        $totalStudents = $allStudents->count();

        if ($totalStudents === 0) {
            return [
                'total' => 0,
                'boys' => 0,
                'girls' => 0,
                'average_age' => 0,
                'attendance_rate' => 0,
                'average_grade' => 0,
            ];
        }

        return [
            'total' => $totalStudents,
            'boys' => $allStudents->where('gender', 'M')->count(),
            'girls' => $allStudents->where('gender', 'F')->count(),
            'average_age' => round($allStudents->avg(function ($student) {
                return $student->age;
            })),
            'attendance_rate' => round($allStudents->avg(function ($student) {
                return $student->getAttendanceRateAttribute();
            }), 1),
            'average_grade' => round($allStudents->flatMap(function ($student) {
                return $student->grades;
            })->avg('score') ?? 0, 2),
        ];
    }

    public function getClassBreakdown()
    {
        $breakdown = [];

        foreach ($this->classes as $class) {
            $studentsCount = Student::where('class_id', $class->id)
                ->where('status', 'active')
                ->count();

            $breakdown[] = [
                'class' => $class->full_name,
                'count' => $studentsCount,
                'capacity' => $class->capacity,
                'percentage' => $class->capacity > 0 ? round(($studentsCount / $class->capacity) * 100, 1) : 0,
            ];
        }

        return $breakdown;
    }

    public function exportStudents()
    {
        // Logic pour export Excel/PDF
        session()->flash('info', 'Export en cours de développement');
    }

    public function render()
    {
        $globalStats = $this->getGlobalStats();
        $classBreakdown = $this->getClassBreakdown();

        return view('livewire.professor.my-students', [
            'globalStats' => $globalStats,
            'classBreakdown' => $classBreakdown,
        ]);
    }
}