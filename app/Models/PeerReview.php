<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
class PeerReview extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'reviewer_id',
        'rating',
        'review_text',
        'criteria_scores',
        'status',
        'completed_at',
    ];

    protected $casts = [
        'criteria_scores' => 'array',
        'completed_at' => 'datetime',
        'rating' => 'decimal:2',
    ];

    /**
     * 🔗 Relation : le review appartient à une soumission
     */
    public function submission()
    {
        return $this->belongsTo(AssignmentSubmission::class);
    }

    /**
     * 👨‍🎓 Relation : l'étudiant qui fait la revue
     */
    public function reviewer()
    {
        return $this->belongsTo(Student::class, 'reviewer_id');
    }

    /**
     * ✅ Vérifie si la revue est complétée
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * 🕓 Marquer la revue comme terminée
     */
    public function markAsCompleted(): void
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => Carbon::now(),
        ]);
    }

    /**
     * ⭐ Formater la note
     */
    // public function getFormattedRatingAttribute(): string
    // {
    //     return $this->rating ? number_format($this->rating, 2) . '/5' : 'N/A';
    // }
    public function getFormattedRatingAttribute(): string
    {
        $rating = $this->rating;

        // Vérifier que c'est un nombre valide
        if (!is_numeric($rating) || $rating < 0) {
            return 'N/A';
        }

        return number_format((float) $rating, 2) . '/5';
    }

    /**
     * 📊 Retourne la moyenne d’un ensemble de critères
     */
    public function getAverageCriteriaScoreAttribute(): ?float
    {
        if (!$this->criteria_scores || !is_array($this->criteria_scores)) {
            return null;
        }

        return round(array_sum($this->criteria_scores) / count($this->criteria_scores), 2);
    }
}
