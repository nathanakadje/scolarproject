<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Evaluation extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'name',
        'subject_id',
        'class_id',
        'academic_year_id',
        'teacher_id',
        'type',
        'date',
        'max_score',
        'duration_minutes',
        'description',
        'status',
        'is_published'
    ];

    protected $casts = [
        'date' => 'date',
        'max_score' => 'decimal:2',
    ];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }


    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function getGradedCount()
    {
        return $this->grades()->count();
    }
    /*
    Retrieve the total number of students in the class associated with this assessment.
    */
    public function getTotalStudents()
    {
        return $this->class ? $this->class->students()->count() : 0;
    }
}
