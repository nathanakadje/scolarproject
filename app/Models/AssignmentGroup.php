<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssignmentGroup extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'name',
        'leader_id',
    ];

    /**
     * 🔗 Relation : le groupe appartient à un devoir (assignment)
     */
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    /**
     * 👨‍🎓 Relation : le leader du groupe est un étudiant
     */
    public function leader()
    {
        return $this->belongsTo(Student::class, 'leader_id');
    }

    /**
     * 👥 (Optionnel) Si tu veux ajouter les membres du groupe
     * via une table pivot `assignment_group_student`
     */
    public function members()
    {
        return $this->belongsToMany(Student::class, 'assignment_group_student', 'group_id', 'student_id')
            ->withTimestamps();
    }
}
