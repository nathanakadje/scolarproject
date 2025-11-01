<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class AssignmentAnalytics extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'date',
        'views',
        'submissions',
        'average_grade',
        'late_submissions',
        'on_time_submissions',
    ];

    protected $casts = [
        'date' => 'date',
        'average_grade' => 'decimal:2',
    ];

    /**
     * 🔗 Relation : ces stats appartiennent à un devoir
     */
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    /**
     * 📊 Calcul du taux de retard
     */
    public function getLateRateAttribute(): float
    {
        $total = $this->late_submissions + $this->on_time_submissions;
        return $total > 0 ? round(($this->late_submissions / $total) * 100, 2) : 0;
    }

    /**
     * ⚙️ Incrémenter les vues
     */
    public function incrementViews(int $count = 1): void
    {
        $this->increment('views', $count);
    }

    /**
     * ⚙️ Incrémenter les soumissions
     */
    public function incrementSubmissions(bool $isLate = false): void
    {
        $this->increment('submissions');
        if ($isLate) {
            $this->increment('late_submissions');
        } else {
            $this->increment('on_time_submissions');
        }
    }

    /**
     * 🔢 Met à jour la moyenne des notes
     */
    // private static function calculateChange(?float $current, ?float $previous): ?float
    // {
    //     if ($previous === null || $previous == 0) {
    //         return null;
    //     }

    //     return round((($current - $previous) / $previous) * 100, 2);
    // }


}
