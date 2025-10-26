<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class TimetableSession extends Model
{
    //
    protected $fillable = [
        'teacher_id',
        'class_id',
        'subject_id',
        'day_of_week',
        'start_time',
        'end_time',
        'room',
        'building',
        'valid_from',
        'valid_until',
        'academic_year',
        'semester',
        'session_type',
        'is_active',
        'notes'
    ];

    protected $casts = [
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_active' => 'boolean',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function classe(): BelongsTo
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('valid_from', '<=', today())
            ->where(function ($q) {
                $q->whereNull('valid_until')
                    ->orWhere('valid_until', '>=', today());
            });
    }

    public function scopeForDay($query, $dayOfWeek)
    {
        return $query->where('day_of_week', $dayOfWeek);
    }

    public function getDayLabel(): string
    {
        return match ($this->day_of_week) {
            'monday' => 'Lundi',
            'tuesday' => 'Mardi',
            'wednesday' => 'Mercredi',
            'thursday' => 'Jeudi',
            'friday' => 'Vendredi',
            'saturday' => 'Samedi',
            'sunday' => 'Dimanche',
            default => $this->day_of_week,
        };
    }

    public function getSessionTypeLabel(): string
    {
        return match ($this->session_type) {
            'course' => 'Cours magistral',
            'td' => 'Travaux dirigés',
            'tp' => 'Travaux pratiques',
            'permanent' => 'Permanence',
            'support' => 'Soutien',
            default => $this->session_type,
        };
    }
    // Propriété calculée pour le titre affiché dans le calendrier
    public function getTitleAttribute()
    {
        return $this->subject->name . ' (' . $this->classe->name . ')';
    }

    // Propriété calculée pour la couleur (exemple simple)
    public function getColorAttribute()
    {
        return '#10B981'; // tu peux adapter par matière ou type de séance
    }

    // Propriété calculée pour l'emplacement
    public function getLocationAttribute()
    {
        return $this->room . ($this->building ? ' - ' . $this->building : '');
    }
}
