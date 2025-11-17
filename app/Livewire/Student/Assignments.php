<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Student;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;

#[Layout('layouts.student-layout')]
class Assignments extends Component
{
    use WithPagination, WithFileUploads;

    public $student;
    public $filterStatus = 'all'; // all, pending, submitted, graded, late
    public $search = '';

    // Submission Modal
    public $showSubmissionModal = false;
    public $selectedAssignment = null;
    public $submissionContent = '';
    public $submissionFiles = [];

    public function mount()
    {
        $this->student = Student::where('user_id', auth()->id())->first();
    }

    public function getAssignmentsProperty()
    {
        if (!$this->student || !$this->student->classe_id) {
            return collect();
        }

        $query = Assignment::where('class_id', $this->student->classe_id)
            ->where('status', 'published')
            ->with([
                'subject',
                'submissions' => function ($q) {
                    $q->where('student_id', $this->student->id);
                }
            ])
            ->when($this->search, function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%');
            });

        // Apply filters
        if ($this->filterStatus === 'pending') {
            $query->whereDoesntHave('submissions', function ($q) {
                $q->where('student_id', $this->student->id)
                    ->whereNotNull('submitted_at');
            });
        } elseif ($this->filterStatus === 'submitted') {
            $query->whereHas('submissions', function ($q) {
                $q->where('student_id', $this->student->id)
                    ->whereNotNull('submitted_at')
                    ->whereNull('score');
            });
        } elseif ($this->filterStatus === 'graded') {
            $query->whereHas('submissions', function ($q) {
                $q->where('student_id', $this->student->id)
                    ->whereNotNull('score');
            });
        } elseif ($this->filterStatus === 'late') {
            $query->where('due_date', '<', now())
                ->whereDoesntHave('submissions', function ($q) {
                    $q->where('student_id', $this->student->id)
                        ->whereNotNull('submitted_at');
                });
        }

        return $query->orderBy('due_date', 'asc')->paginate(10);
    }

    public function getStatsProperty()
    {
        $allAssignments = Assignment::where('class_id', $this->student->classe_id)
            ->where('status', 'published')
            ->get();

        $pending = 0;
        $submitted = 0;
        $graded = 0;
        $late = 0;

        foreach ($allAssignments as $assignment) {
            $submission = $assignment->submissions->where('student_id', $this->student->id)->first();

            if (!$submission || !$submission->submitted_at) {
                if ($assignment->due_date < now()) {
                    $late++;
                } else {
                    $pending++;
                }
            } elseif ($submission->submitted_at && !$submission->score) {
                $submitted++;
            } elseif ($submission->score) {
                $graded++;
            }
        }

        return [
            'total' => $allAssignments->count(),
            'pending' => $pending,
            'submitted' => $submitted,
            'graded' => $graded,
            'late' => $late,
        ];
    }

    public function openSubmissionModal($assignmentId)
    {
        $this->selectedAssignment = Assignment::with([
            'subject',
            'submissions' => function ($q) {
                $q->where('student_id', $this->student->id);
            }
        ])->findOrFail($assignmentId);

        $this->showSubmissionModal = true;
        $this->submissionContent = '';
        $this->submissionFiles = [];
    }

    public function closeSubmissionModal()
    {
        $this->showSubmissionModal = false;
        $this->selectedAssignment = null;
        $this->submissionContent = '';
        $this->submissionFiles = [];
    }

    public function submitAssignment()
    {
        $this->validate([
            'submissionContent' => 'nullable|string|max:5000',
            'submissionFiles.*' => 'nullable|file|max:10240', // 10MB
        ]);

        $submission = AssignmentSubmission::where('assignment_id', $this->selectedAssignment->id)
            ->where('student_id', $this->student->id)
            ->first();

        if (!$submission) {
            $submission = AssignmentSubmission::create([
                'assignment_id' => $this->selectedAssignment->id,
                'student_id' => $this->student->id,
                'status' => 'pending',
            ]);
        }

        // Upload files
        $uploadedFiles = [];
        if (!empty($this->submissionFiles)) {
            foreach ($this->submissionFiles as $file) {
                $path = $file->store('submissions', 'public');
                $uploadedFiles[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType(),
                ];
            }
        }

        // Update submission
        $isLate = now() > $this->selectedAssignment->due_date;

        $submission->update([
            'content' => $this->submissionContent,
            'attachments' => $uploadedFiles,
            'submitted_at' => now(),
            'status' => $isLate ? 'late' : 'submitted',
        ]);

        session()->flash('success', 'Devoir soumis avec succès !');
        $this->closeSubmissionModal();
    }

    public function render()
    {
        return view('livewire.student.assignments', [
            'assignments' => $this->assignments,
            'stats' => $this->stats,
        ]);
    }
}
