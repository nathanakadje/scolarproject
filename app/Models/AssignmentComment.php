<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class AssignmentComment extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'submission_id',
        'commentable_id',
        'commentable_type',
        'comment',
        'parent_id',
        'is_private',
    ];

    /**
     * 🔗 Relation : le commentaire appartient à un devoir
     */
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    /**
     * 🔗 Relation : le commentaire peut être lié à une soumission (optionnelle)
     */
    public function submission()
    {
        return $this->belongsTo(AssignmentSubmission::class);
    }

    /**
     * 👤 Relation polymorphique : auteur du commentaire (Teacher ou Student)
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * 💬 Relation : commentaires enfants (réponses)
     */
    public function replies()
    {
        return $this->hasMany(AssignmentComment::class, 'parent_id');
    }

    /**
     * ↩️ Relation : commentaire parent
     */
    public function parent()
    {
        return $this->belongsTo(AssignmentComment::class, 'parent_id');
    }

    /**
     * 🕵️‍♂️ Vérifie si le commentaire est privé
     */
    public function isPrivate(): bool
    {
        return (bool) $this->is_private;
    }
}
