<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Assignment extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'teacher_id',
        'class_id',
        'subject_id',
        'title',
        'description',
        'instructions',
        'type',
        'difficulty',
        'max_points',
        'assigned_date',
        'due_date',
        'late_submission_date',
        'estimated_duration',
        'allow_late_submission',
        'late_penalty_percent',
        'allow_file_upload',
        'allow_text_submission',
        'allowed_file_types',
        'max_file_size',
        'max_files',
        'group_assignment',
        'max_group_size',
        'peer_review_enabled',
        'peer_reviews_required',
        'auto_grade',
        'rubric',
        'status',
        'send_reminders',
        'reminder_days_before',
        'resources_links',
        'submission_count',
        'graded_count',
    ];

    protected $casts = [
        'assigned_date' => 'datetime',
        'due_date' => 'datetime',
        'late_submission_date' => 'datetime',
        'allow_late_submission' => 'boolean',
        'allow_file_upload' => 'boolean',
        'allow_text_submission' => 'boolean',
        'allowed_file_types' => 'array',
        'group_assignment' => 'boolean',
        'peer_review_enabled' => 'boolean',
        'auto_grade' => 'boolean',
        'rubric' => 'array',
        'send_reminders' => 'boolean',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(AssignmentAttachment::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(AssignmentComment::class);
    }

    public function groups(): HasMany
    {
        return $this->hasMany(AssignmentGroup::class);
    }

    public function reminders(): HasMany
    {
        return $this->hasMany(AssignmentReminder::class);
    }

    public function analytics(): HasMany
    {
        return $this->hasMany(AssignmentAnalytics::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePublished($query)
    {
        return $query->whereIn('status', ['published', 'active']);
    }

    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())
            ->where('status', 'active');
    }

    public function scopeDueSoon($query, $days = 3)
    {
        return $query->whereBetween('due_date', [now(), now()->addDays($days)])
            ->where('status', 'active');
    }

    // Getters
    public function getIsOverdueAttribute(): bool
    {
        return $this->due_date->isPast() && $this->status === 'active';
    }

    public function getDaysUntilDueAttribute(): int
    {
        return now()->diffInDays($this->due_date, false);
    }

    public function getSubmissionRateAttribute(): float
    {
        $totalStudents = $this->class->students()->count();
        return $totalStudents > 0 ? ($this->submission_count / $totalStudents) * 100 : 0;
    }

    public function getGradingProgressAttribute(): float
    {
        return $this->submission_count > 0 ? ($this->graded_count / $this->submission_count) * 100 : 0;
    }

    public function getAverageGradeAttribute(): ?float
    {
        return $this->submissions()->whereNotNull('grade')->avg('grade');
    }

    public function getTypeIconAttribute(): string
    {
        return match ($this->type) {
            'homework' => '📝',
            'project' => '🎯',
            'exercise' => '💪',
            'research' => '🔬',
            'presentation' => '🎤',
            default => '📄'
        };
    }

    public function getDifficultyColorAttribute(): string
    {
        return match ($this->difficulty) {
            'easy' => 'green',
            'medium' => 'yellow',
            'hard' => 'orange',
            'expert' => 'red',
            default => 'gray'
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'gray',
            'published' => 'blue',
            'active' => 'green',
            'closed' => 'orange',
            'archived' => 'red',
            default => 'gray'
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'Brouillon',
            'published' => 'Publié',
            'active' => 'En cours',
            'closed' => 'Fermé',
            'archived' => 'Archivé',
            default => 'Inconnu'
        };
    }

    // Methods
    public function publish(): void
    {
        $this->update(['status' => 'published', 'assigned_date' => now()]);
        $this->sendNotificationsToStudents();
    }

    public function close(): void
    {
        $this->update(['status' => 'closed']);
    }

    public function archive(): void
    {
        $this->update(['status' => 'archived']);
    }

    protected function sendNotificationsToStudents(): void
    {
        // Implementation for sending notifications
    }
}
