<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class CalendarEvent extends Model
{
    //
    protected $fillable = [
        'title',
        'description',
        'created_by',
        'type',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'all_day',
        'class_id',
        'subject_id',
        'evaluation_id',
        'location',
        'color',
        'icon',
        'is_recurring',
        'recurrence_type',
        'recurrence_interval',
        'recurrence_end_date',
        'has_reminder',
        'reminder_minutes',
        'visibility',
        'status',
        'participants',
        'priority',
        'notes',
        'attachments'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'recurrence_end_date' => 'date',
        'all_day' => 'boolean',
        'is_recurring' => 'boolean',
        'has_reminder' => 'boolean',
        'participants' => 'array',
        'attachments' => 'array',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function classe(): BelongsTo
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function evaluation(): BelongsTo
    {
        return $this->belongsTo(Evaluation::class, 'evaluation_id');
    }

    public function reminders(): HasMany
    {
        return $this->hasMany(EventReminder::class, 'event_id');
    }

    // Scopes
    public function scopeUpcoming($query, $days = 7)
    {
        return $query->where('start_date', '>=', today())
            ->where('start_date', '<=', today()->addDays($days))
            ->where('status', 'scheduled')
            ->orderBy('start_date')
            ->orderBy('start_time');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeForTeacher($query, $teacherId)
    {
        return $query->where('created_by', $teacherId)
            ->orWhereJsonContains('participants', $teacherId);
    }

    public function scopeInDateRange($query, $startDate, $endDate)
    {
        return $query->where(function ($q) use ($startDate, $endDate) {
            $q->whereBetween('start_date', [$startDate, $endDate])
                ->orWhereBetween('end_date', [$startDate, $endDate])
                ->orWhere(function ($q2) use ($startDate, $endDate) {
                    $q2->where('start_date', '<=', $startDate)
                        ->where('end_date', '>=', $endDate);
                });
        });
    }

    // Helper methods
    public function getTypeLabel(): string
    {
        return match ($this->type) {
            'evaluation' => '📝 Évaluation',
            'course' => '📚 Cours',
            'meeting' => '👥 Réunion',
            'deadline' => '⏰ Date limite',
            'holiday' => '🏖️ Vacances',
            'event' => '🎉 Événement',
            'personal' => '👤 Personnel',
            'revision' => '📖 Révision',
            'trip' => '🚌 Sortie',
            'ceremony' => '🎓 Cérémonie',
            'parent_meeting' => '👨‍👩‍👧 Rencontre parents',
            'pedagogical' => '🏫 Journée pédagogique',
            default => $this->type,
        };
    }

    public function getPriorityColor(): string
    {
        return match ($this->priority) {
            'urgent' => 'red',
            'high' => 'orange',
            'medium' => 'yellow',
            'low' => 'blue',
            default => 'gray',
        };
    }

    public function getStatusBadgeColor(): string
    {
        return match ($this->status) {
            'scheduled' => 'blue',
            'completed' => 'green',
            'cancelled' => 'red',
            'postponed' => 'yellow',
            default => 'gray',
        };
    }

    // public function isMultiDay(): bool
    // {
    //     return $this->end_date && $this->start_date->ne($this->end_date);
    // }
    public function isMultiDay(): bool
    {
        if (!$this->end_date) {
            return false;
        }

        return !Carbon::parse($this->start_date)->eq(Carbon::parse($this->end_date));
    }

    // public function isPast(): bool
    // {
    //     $compareDate = $this->end_date ?? $this->start_date;
    //     return $compareDate->isPast();
    // }
    public function isPast(): bool
    {
        $compareDate = $this->end_date ?? $this->start_date;

        return Carbon::parse($compareDate)->isPast();
    }

    public function isToday(): bool
    {
        return Carbon::parse($this->start_date)->isToday();
    }

    public function getDuration(): ?string
    {
        if (!$this->start_time || !$this->end_time) {
            return null;
        }

        $start = Carbon::parse($this->start_time);
        $end = Carbon::parse($this->end_time);
        $diff = $start->diff($end);

        return sprintf('%dh%02d', $diff->h, $diff->i);
    }

    protected static function booted()
    {
        static::created(function ($event) {
            $event->createNotification();
        });

        static::updated(function ($event) {
            if ($event->isDirty(['title', 'start_date', 'start_time', 'location'])) {
                $event->updateNotification();
            }
        });

        static::deleting(function ($event) {
            $event->deleteNotification();
        });
    }

    public function createNotification()
    {
        // Créer une notification pour chaque étudiant de la classe
        $students = $this->classe->students;

        foreach ($students as $student) {
            Notification::create([
                'notifiable_id' => $student->id,
                'notifiable_type' => 'App\Models\Student',
                'type' => 'calendar_event',
                'title' => 'Nouvel événement : ' . $this->title,
                'message' => $this->description ?? 'Un nouvel événement a été programmé.',
                'data' => [
                    'start_date' => $this->start_date,
                    'start_time' => $this->start_time,
                    'location' => $this->location,
                    'subject_name' => $this->subject->name ?? null,
                    'event_type' => $this->type,
                ],
                'related_id' => $this->id,
                'related_type' => 'App\Models\CalendarEvent',
                'priority' => $this->getNotificationPriority(),
                'icon' => '📅',
                'color' => '#3B82F6', // Bleu pour les événements
            ]);
        }
    }

    public function updateNotification()
    {
        // Mettre à jour les notifications existantes
        Notification::where('related_id', $this->id)
            ->where('related_type', 'App\Models\CalendarEvent')
            ->update([
                'title' => 'Événement modifié : ' . $this->title,
                'message' => $this->description ?? 'Un événement a été modifié.',
                'data' => [
                    'start_date' => $this->start_date,
                    'start_time' => $this->start_time,
                    'location' => $this->location,
                    'subject_name' => $this->subject->name ?? null,
                    'event_type' => $this->type,
                ],
                'priority' => $this->getNotificationPriority(),
            ]);
    }

    public function deleteNotification()
    {
        // Supprimer les notifications liées
        Notification::where('related_id', $this->id)
            ->where('related_type', 'App\Models\CalendarEvent')
            ->delete();
    }

    private function getNotificationPriority()
    {
        // Déterminer la priorité selon la date
        $daysUntilEvent = now()->diffInDays($this->start_date);

        if ($daysUntilEvent <= 1) {
            return 'urgent';
        } elseif ($daysUntilEvent <= 3) {
            return 'high';
        } else {
            return 'normal';
        }
    }
}
