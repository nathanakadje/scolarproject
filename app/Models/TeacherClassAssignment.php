<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeacherClassAssignment extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'teacher_id',
        'class_id',
        'subject_id',
        'academic_year_id',
        'is_main_teacher'
    ];

    protected $casts = [
        'is_main_teacher' => 'boolean',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(ClassModel::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }


    // protected $fillable = [
    //     'teacher_id',
    //     'class_id',
    //     'subject_id',
    //     'academic_year_id',
    //     'is_main_teacher'
    // ];

    // protected $casts = [
    //     'is_main_teacher' => 'boolean',
    // ];

    // // Relations
    // public function teacher()
    // {
    //     return $this->belongsTo(Teacher::class);
    // }

    // public function class()
    // {
    //     return $this->belongsTo(ClassModel::class);
    // }

    // public function subject()
    // {
    //     return $this->belongsTo(Subject::class);
    // }

    // public function academicYear()
    // {
    //     return $this->belongsTo(AcademicYear::class);
    // }
}
