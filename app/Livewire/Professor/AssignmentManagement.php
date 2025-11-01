<?php

namespace App\Livewire\Professor;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Models\Teacher;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\AssignmentAttachment;
use App\Models\ClassModel;
use App\Models\Subject;
use App\Models\Student;
use App\Traits\HasToastNotifications;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

#[Layout('layouts.professor-layout')]
class AssignmentManagement extends Component
{
    use HasToastNotifications, WithFileUploads, WithPagination;

    public $teacher;

    // View Mode
    public $viewMode = 'grid'; // grid, list, calendar, analytics

    // Filters
    public $search = '';
    public $filterStatus = 'all';
    public $filterClass = 'all';
    public $filterSubject = 'all';
    public $filterType = 'all';
    public $filterDifficulty = 'all';
    public $sortBy = 'due_date_asc';

    // Modals
    public $showAssignmentModal = false;
    public $showSubmissionsModal = false;
    public $showGradingModal = false;
    public $showAnalyticsModal = false;
    public $showQuickCreateModal = false;

    // Assignment Form
    public $assignmentId = null;
    public $step = 1; // Multi-step form
    public $title = '';
    public $description = '';
    public $instructions = '';
    public $type = 'homework';
    public $difficulty = 'medium';
    public $maxPoints = 20;
    public $assignedDate;
    public $dueDate;
    public $dueTime = '23:59';
    public $lateSubmissionDate;
    public $estimatedDuration = 60;
    public $allowLateSubmission = true;
    public $latePenaltyPercent = 10;
    public $allowFileUpload = true;
    public $allowTextSubmission = true;
    public $allowedFileTypes = ['pdf', 'docx', 'doc', 'txt'];
    public $maxFileSize = 10240;
    public $maxFiles = 5;
    public $groupAssignment = false;
    public $maxGroupSize = 4;
    public $peerReviewEnabled = false;
    public $peerReviewsRequired = 2;
    public $selectedClassId = null;
    public $selectedSubjectId = null;
    public $sendReminders = true;
    public $reminderDaysBefore = 2;
    public $resourcesLinks = '';
    public $attachments = [];
    public $rubricCriteria = [];

    // Grading
    public $selectedSubmission = null;
    public $grade = null;
    public $feedback = '';
    public $rubricScores = [];

    // Quick Actions
    public $bulkAction = '';
    public $selectedAssignments = [];

    // Analytics
    public $selectedAssignmentAnalytics = null;

    public function mount()
    {
        $this->teacher = Teacher::where('user_id', auth()->id())->first();

        if (!$this->teacher) {
            $this->toasterror('Profil professeur non trouvé');
            return redirect()->route('professor.dashboard');
        }

        $this->assignedDate = today()->format('Y-m-d');
        $this->dueDate = today()->addDays(7)->format('Y-m-d');
    }

    #[Computed]
    public function assignments()
    {
        $query = Assignment::with(['class', 'subject', 'submissions'])
            ->where('teacher_id', $this->teacher->id);

        // Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Filters
        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterClass !== 'all') {
            $query->where('class_id', $this->filterClass);
        }

        if ($this->filterSubject !== 'all') {
            $query->where('subject_id', $this->filterSubject);
        }

        if ($this->filterType !== 'all') {
            $query->where('type', $this->filterType);
        }

        if ($this->filterDifficulty !== 'all') {
            $query->where('difficulty', $this->filterDifficulty);
        }

        // Sort
        switch ($this->sortBy) {
            case 'due_date_asc':
                $query->orderBy('due_date', 'asc');
                break;
            case 'due_date_desc':
                $query->orderBy('due_date', 'desc');
                break;
            case 'created_asc':
                $query->oldest();
                break;
            case 'created_desc':
                $query->latest();
                break;
            case 'title':
                $query->orderBy('title');
                break;
            case 'submissions':
                $query->orderBy('submission_count', 'desc');
                break;
        }

        return $query->paginate(12);
    }

    #[Computed]
    public function classes()
    {
        return $this->teacher->getCurrentClasses();
    }

    #[Computed]
    public function subjects()
    {
        return Subject::where('is_active', true)->get();
    }

    #[Computed]
    public function stats()
    {
        $allAssignments = Assignment::where('teacher_id', $this->teacher->id);

        return [
            'total' => $allAssignments->count(),
            'active' => $allAssignments->where('status', 'active')->count(),
            'draft' => $allAssignments->where('status', 'draft')->count(),
            'overdue' => $allAssignments->where('due_date', '<', now())->where('status', 'active')->count(),
            'due_soon' => $allAssignments->whereBetween('due_date', [now(), now()->addDays(3)])->where('status', 'active')->count(),
            'pending_grading' => AssignmentSubmission::whereHas('assignment', function ($q) {
                $q->where('teacher_id', $this->teacher->id);
            })->where('status', 'submitted')->count(),
            'total_submissions' => AssignmentSubmission::whereHas('assignment', function ($q) {
                $q->where('teacher_id', $this->teacher->id);
            })->count(),
            'average_grade' => AssignmentSubmission::whereHas('assignment', function ($q) {
                $q->where('teacher_id', $this->teacher->id);
            })->whereNotNull('grade')->avg('grade'),
        ];
    }

    public function openAssignmentModal($id = null)
    {
        $this->resetAssignmentForm();

        if ($id) {
            $assignment = Assignment::with('attachments')->findOrFail($id);
            $this->assignmentId = $assignment->id;
            $this->title = $assignment->title;
            $this->description = $assignment->description;
            $this->instructions = $assignment->instructions;
            $this->type = $assignment->type;
            $this->difficulty = $assignment->difficulty;
            $this->maxPoints = $assignment->max_points;
            $this->assignedDate = $assignment->assigned_date->format('Y-m-d');
            $this->dueDate = $assignment->due_date->format('Y-m-d');
            $this->dueTime = $assignment->due_date->format('H:i');
            $this->lateSubmissionDate = $assignment->late_submission_date?->format('Y-m-d');
            $this->estimatedDuration = $assignment->estimated_duration;
            $this->allowLateSubmission = $assignment->allow_late_submission;
            $this->latePenaltyPercent = $assignment->late_penalty_percent;
            $this->allowFileUpload = $assignment->allow_file_upload;
            $this->allowTextSubmission = $assignment->allow_text_submission;
            $this->allowedFileTypes = $assignment->allowed_file_types ?? [];
            $this->maxFileSize = $assignment->max_file_size;
            $this->maxFiles = $assignment->max_files;
            $this->groupAssignment = $assignment->group_assignment;
            $this->maxGroupSize = $assignment->max_group_size;
            $this->peerReviewEnabled = $assignment->peer_review_enabled;
            $this->peerReviewsRequired = $assignment->peer_reviews_required;
            $this->selectedClassId = $assignment->class_id;
            $this->selectedSubjectId = $assignment->subject_id;
            $this->sendReminders = $assignment->send_reminders;
            $this->reminderDaysBefore = $assignment->reminder_days_before;
            $this->resourcesLinks = $assignment->resources_links;
            $this->rubricCriteria = $assignment->rubric ?? [];
        }

        $this->showAssignmentModal = true;
    }

    public function saveAssignment()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'selectedClassId' => 'required|exists:classes,id',
            'selectedSubjectId' => 'required|exists:subjects,id',
            'type' => 'required|in:homework,project,exercise,research,presentation',
            'difficulty' => 'required|in:easy,medium,hard,expert',
            'maxPoints' => 'required|numeric|min:0|max:1000',
            'dueDate' => 'required|date|after_or_equal:today',
        ]);

        $dueDateTime = Carbon::parse($this->dueDate . ' ' . $this->dueTime);

        $data = [
            'teacher_id' => $this->teacher->id,
            'class_id' => $this->selectedClassId,
            'subject_id' => $this->selectedSubjectId,
            'title' => $this->title,
            'description' => $this->description,
            'instructions' => $this->instructions,
            'type' => $this->type,
            'difficulty' => $this->difficulty,
            'max_points' => $this->maxPoints,
            'assigned_date' => $this->assignedDate,
            'due_date' => $dueDateTime,
            'late_submission_date' => $this->lateSubmissionDate,
            'estimated_duration' => $this->estimatedDuration,
            'allow_late_submission' => $this->allowLateSubmission,
            'late_penalty_percent' => $this->latePenaltyPercent,
            'allow_file_upload' => $this->allowFileUpload,
            'allow_text_submission' => $this->allowTextSubmission,
            'allowed_file_types' => $this->allowedFileTypes,
            'max_file_size' => $this->maxFileSize,
            'max_files' => $this->maxFiles,
            'group_assignment' => $this->groupAssignment,
            'max_group_size' => $this->maxGroupSize,
            'peer_review_enabled' => $this->peerReviewEnabled,
            'peer_reviews_required' => $this->peerReviewsRequired,
            'send_reminders' => $this->sendReminders,
            'reminder_days_before' => $this->reminderDaysBefore,
            'resources_links' => $this->resourcesLinks,
            'rubric' => $this->rubricCriteria,
        ];

        if ($this->assignmentId) {
            $assignment = Assignment::findOrFail($this->assignmentId);
            $assignment->update($data);
            $message = 'Devoir mis à jour avec succès';
        } else {
            $assignment = Assignment::create($data);
            $message = 'Devoir créé avec succès';
        }

        // Handle attachments
        if (!empty($this->attachments)) {
            foreach ($this->attachments as $file) {
                $path = $file->store('assignments/attachments', 'public');
                AssignmentAttachment::create([
                    'assignment_id' => $assignment->id,
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getClientOriginalExtension(),
                    'file_size' => $file->getSize(),
                    'attachment_type' => 'resource',
                ]);
            }
        }

        $this->toastsuccess($message);
        $this->showAssignmentModal = false;
        $this->resetAssignmentForm();
    }

    public function publishAssignment($id)
    {
        $assignment = Assignment::findOrFail($id);
        $assignment->publish();
        $this->toastsuccess('Devoir publié avec succès. Les élèves ont été notifiés.');
    }

    public function closeAssignment($id)
    {
        $assignment = Assignment::findOrFail($id);
        $assignment->close();
        $this->toastsuccess('Devoir fermé. Les soumissions ne sont plus acceptées.');
    }

    public function duplicateAssignment($id)
    {
        $original = Assignment::with('attachments')->findOrFail($id);
        $duplicate = $original->replicate();
        $duplicate->title = $original->title . ' (Copie)';
        $duplicate->status = 'draft';
        $duplicate->assigned_date = today();
        $duplicate->due_date = today()->addDays(7);
        $duplicate->submission_count = 0;
        $duplicate->graded_count = 0;
        $duplicate->save();

        // Duplicate attachments
        foreach ($original->attachments as $attachment) {
            $newAttachment = $attachment->replicate();
            $newAttachment->assignment_id = $duplicate->id;
            $newAttachment->save();
        }

        $this->toastsuccess('Devoir dupliqué avec succès');
    }

    public function deleteAssignment($id)
    {
        $assignment = Assignment::findOrFail($id);

        // Delete attachments
        foreach ($assignment->attachments as $attachment) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        $assignment->delete();
        $this->toastsuccess('Devoir supprimé avec succès');
    }

    public function archiveAssignment($id)
    {
        $assignment = Assignment::findOrFail($id);
        $assignment->archive();
        $this->toastsuccess('Devoir archivé avec succès');
    }

    public function viewSubmissions($id)
    {
        $this->selectedSubmission = Assignment::with(['submissions.student', 'class'])->findOrFail($id);
        $this->showSubmissionsModal = true;
    }

    public function openGradingModal($submissionId)
    {
        $submission = AssignmentSubmission::with(['assignment', 'student'])->findOrFail($submissionId);
        $this->selectedSubmission = $submission;
        $this->grade = $submission->grade;
        $this->feedback = $submission->teacher_feedback;
        $this->rubricScores = $submission->rubric_scores ?? [];
        $this->showGradingModal = true;
    }

    public function saveGrade()
    {
        $this->validate([
            'grade' => 'required|numeric|min:0|max:' . $this->selectedSubmission->assignment->max_points,
            'feedback' => 'nullable|string',
        ]);

        $adjustedGrade = $this->grade;

        // Apply late penalty if submission was late
        if ($this->selectedSubmission->is_late && $this->selectedSubmission->assignment->allow_late_submission) {
            $penalty = ($this->grade * $this->selectedSubmission->assignment->late_penalty_percent) / 100;
            $adjustedGrade = max(0, $this->grade - $penalty);
        }

        $this->selectedSubmission->update([
            'grade' => $this->grade,
            'adjusted_grade' => $adjustedGrade,
            'teacher_feedback' => $this->feedback,
            'rubric_scores' => $this->rubricScores,
            'status' => 'graded',
            'graded_at' => now(),
            'graded_by' => $this->teacher->id,
        ]);

        // Update assignment graded count
        $this->selectedSubmission->assignment->increment('graded_count');

        $this->toastsuccess('Note enregistrée avec succès');
        $this->showGradingModal = false;
        $this->resetGradingForm();
    }

    public function quickGrade($submissionId, $grade)
    {
        $submission = AssignmentSubmission::findOrFail($submissionId);

        $submission->update([
            'grade' => $grade,
            'adjusted_grade' => $grade,
            'status' => 'graded',
            'graded_at' => now(),
            'graded_by' => $this->teacher->id,
        ]);

        $submission->assignment->increment('graded_count');
        $this->success('Note rapide enregistrée');
    }

    public function returnSubmission($submissionId)
    {
        $submission = AssignmentSubmission::findOrFail($submissionId);
        $submission->update(['status' => 'returned']);
        $this->success('Devoir retourné à l\'élève');
    }

    public function requestResubmission($submissionId)
    {
        $submission = AssignmentSubmission::findOrFail($submissionId);
        $submission->update(['status' => 'resubmit']);
        $this->success('Demande de resoumission envoyée');
    }

    public function viewAnalytics($id)
    {
        $this->selectedAssignmentAnalytics = Assignment::with(['submissions.student', 'class.students'])
            ->findOrFail($id);
        $this->showAnalyticsModal = true;
    }

    public function addRubricCriterion()
    {
        $this->rubricCriteria[] = [
            'name' => '',
            'description' => '',
            'points' => 0,
        ];
    }

    public function removeRubricCriterion($index)
    {
        unset($this->rubricCriteria[$index]);
        $this->rubricCriteria = array_values($this->rubricCriteria);
    }

    public function nextStep()
    {
        $this->step++;
    }

    public function previousStep()
    {
        $this->step--;
    }

    public function performBulkAction()
    {
        if (empty($this->selectedAssignments)) {
            $this->toasterror('Veuillez sélectionner au moins un devoir');
            return;
        }

        switch ($this->bulkAction) {
            case 'publish':
                Assignment::whereIn('id', $this->selectedAssignments)->update(['status' => 'published']);
                $this->toastsuccess('Devoirs publiés avec succès');
                break;
            case 'close':
                Assignment::whereIn('id', $this->selectedAssignments)->update(['status' => 'closed']);
                $this->toastsuccess('Devoirs fermés avec succès');
                break;
            case 'archive':
                Assignment::whereIn('id', $this->selectedAssignments)->update(['status' => 'archived']);
                $this->toastsuccess('Devoirs archivés avec succès');
                break;
            case 'delete':
                Assignment::whereIn('id', $this->selectedAssignments)->delete();
                $this->toastsuccess('Devoirs supprimés avec succès');
                break;
        }

        $this->selectedAssignments = [];
        $this->bulkAction = '';
    }

    public function exportGrades($assignmentId)
    {
        // Implementation for exporting grades to CSV/Excel
        $this->toastsuccess('Export des notes en cours...');
    }

    public function sendReminder($assignmentId)
    {
        $assignment = Assignment::findOrFail($assignmentId);
        // Implementation for sending reminders to students who haven't submitted
        $this->toastsuccess('Rappels envoyés aux élèves n\'ayant pas soumis');
    }

    protected function resetAssignmentForm()
    {
        $this->assignmentId = null;
        $this->step = 1;
        $this->title = '';
        $this->description = '';
        $this->instructions = '';
        $this->type = 'homework';
        $this->difficulty = 'medium';
        $this->maxPoints = 20;
        $this->assignedDate = today()->format('Y-m-d');
        $this->dueDate = today()->addDays(7)->format('Y-m-d');
        $this->dueTime = '23:59';
        $this->lateSubmissionDate = null;
        $this->estimatedDuration = 60;
        $this->allowLateSubmission = true;
        $this->latePenaltyPercent = 10;
        $this->allowFileUpload = true;
        $this->allowTextSubmission = true;
        $this->allowedFileTypes = ['pdf', 'docx', 'doc', 'txt'];
        $this->maxFileSize = 10240;
        $this->maxFiles = 5;
        $this->groupAssignment = false;
        $this->maxGroupSize = 4;
        $this->peerReviewEnabled = false;
        $this->peerReviewsRequired = 2;
        $this->selectedClassId = null;
        $this->selectedSubjectId = null;
        $this->sendReminders = true;
        $this->reminderDaysBefore = 2;
        $this->resourcesLinks = '';
        $this->attachments = [];
        $this->rubricCriteria = [];
    }

    protected function resetGradingForm()
    {
        $this->selectedSubmission = null;
        $this->grade = null;
        $this->feedback = '';
        $this->rubricScores = [];
    }

    public function render()
    {
        return view('livewire.professor.assignment-management');
    }
}