<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassModel extends Model
{
    //
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'code',
        'academic_level_id',
        'capacity',
        'school_fees',
        'is_active'
    ];

    protected $casts = [
        'school_fees' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function academicLevel(): BelongsTo
    {
        return $this->belongsTo(AcademicLevel::class, 'academic_level_id');
    }
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }


    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'class_id');
    }

    public function teacherAssignments(): HasMany
    {
        return $this->hasMany(TeacherClassAssignment::class, 'class_id');
    }
    // public function students()
    // {
    //     return $this->belongsToMany(Student::class, 'enrollments', 'class_id', 'student_id')
    //         ->withPivot('academic_year_id', 'status');
    // }
    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function timetableSessions()
    {
        return $this->hasMany(TimetableSession::class, 'class_id');
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
    // app/Models/ClassModel.php

    public function mainTeacher()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_class_assignments', 'class_id', 'teacher_id')
            ->wherePivot('is_main_teacher', true)
            ->withPivot('academic_year_id')
            ->withTimestamps()
            ->limit(1);
    }
    // app/Models/Teacher.php

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function resources()
    {
        return $this->belongsToMany(Resource::class, 'resource_class')->withTimestamps();
    }
    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'class_id');
    }

    // app/Models/ClassModel.php


}
