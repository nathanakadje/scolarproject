<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class AssignmentSubmission extends Model
{
    //
    protected $fillable = [
        'assignment_id',
        'student_id',
        'group_id',
        'submission_text',
        'files',
        'submitted_at',
        'is_late',
        'submission_attempt',
        'status',
        'grade',
        'adjusted_grade',
        'teacher_feedback',
        'rubric_scores',
        'graded_at',
        'graded_by',
        'student_comment',
        'time_spent',
    ];

    protected $casts = [
        'files' => 'array',
        'submitted_at' => 'datetime',
        'is_late' => 'boolean',
        'graded_at' => 'datetime',
        'rubric_scores' => 'array',
    ];

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(AssignmentGroup::class, 'group_id');
    }

    public function grader(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'graded_by');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(AssignmentComment::class, 'submission_id');
    }

    public function peerReviews(): HasMany
    {
        return $this->hasMany(PeerReview::class, 'submission_id');
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'submitted' => 'blue',
            'graded' => 'green',
            'returned' => 'purple',
            'resubmit' => 'orange',
            default => 'gray'
        };
    }

    public function getGradeColorAttribute(): string
    {
        if (!$this->grade)
            return 'gray';

        $percentage = ($this->grade / $this->assignment->max_points) * 100;

        if ($percentage >= 90)
            return 'green';
        if ($percentage >= 75)
            return 'blue';
        if ($percentage >= 60)
            return 'yellow';
        if ($percentage >= 50)
            return 'orange';
        return 'red';
    }
}
