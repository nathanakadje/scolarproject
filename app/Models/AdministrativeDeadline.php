<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class AdministrativeDeadline extends Model
{
    //
    protected $fillable = [
        'title',
        'description',
        'deadline_date',
        'deadline_time',
        'category',
        'priority',
        'is_mandatory',
        'created_by',
        'concerned_teachers',
        'completion_status'
    ];

    protected $casts = [
        'deadline_date' => 'date',
        'is_mandatory' => 'boolean',
        'concerned_teachers' => 'array',
        'completion_status' => 'array',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('deadline_date', '>=', today())
            ->orderBy('deadline_date')
            ->orderBy('deadline_time');
    }

    public function scopeOverdue($query)
    {
        return $query->where('deadline_date', '<', today());
    }

    public function isCompletedBy($teacherId): bool
    {
        $status = $this->completion_status ?? [];
        return isset($status[$teacherId]);
    }

    public function markCompletedBy($teacherId): void
    {
        $status = $this->completion_status ?? [];
        $status[$teacherId] = now()->toDateTimeString();
        $this->update(['completion_status' => $status]);
    }

    public function getCategoryLabel(): string
    {
        return match ($this->category) {
            'grades_submission' => '📝 Saisie des notes',
            'reports' => '📄 Rapports',
            'bulletin_closure' => '📋 Clôture bulletins',
            'meeting' => '👥 Réunion',
            'document_submission' => '📎 Dépôt documents',
            'planning' => '📅 Planning',
            default => $this->category,
        };
    }

    public function isPast(): bool
    {
        return Carbon::parse($this->deadline_date)->isPast();
    }

    public function getDaysRemaining(): int
    {
        return max(0, today()->diffInDays($this->deadline_date, false));
    }
}
