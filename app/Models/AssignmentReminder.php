<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
class AssignmentReminder extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'student_id',
        'reminder_date',
        'type',
        'sent',
        'sent_at',
    ];

    protected $casts = [
        'reminder_date' => 'datetime',
        'sent_at' => 'datetime',
        'sent' => 'boolean',
    ];

    /**
     * 🔗 Relation : le rappel appartient à un devoir
     */
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    /**
     * 👨‍🎓 Relation : le rappel concerne un étudiant
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * 🕓 Vérifie si le rappel est en retard
     */
    public function isOverdue(): bool
    {
        return $this->reminder_date->isPast() && !$this->sent;
    }

    /**
     * ✅ Vérifie si le rappel a été envoyé
     */
    public function isSent(): bool
    {
        return $this->sent;
    }

    /**
     * ⏰ Marquer le rappel comme envoyé
     */
    public function markAsSent(): void
    {
        $this->update([
            'sent' => true,
            'sent_at' => Carbon::now(),
        ]);
    }
}
