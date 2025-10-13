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
        return $this->hasMany(TeacherClassAssignment::class);
    }
    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments', 'class_id', 'student_id')
            ->withPivot('academic_year_id', 'status');
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



    // use HasFactory;

    // protected $table = 'classes';

    // protected $fillable = [
    //     'name',
    //     'code',
    //     'academic_level_id',
    //     'capacity',
    //     'school_fees',
    //     'is_active'
    // ];

    // protected $casts = [
    //     'is_active' => 'boolean',
    //     'school_fees' => 'decimal:2',
    // ];

    // // Relations
    // public function academicLevel()
    // {
    //     return $this->belongsTo(AcademicLevel::class);
    // }

    // public function subjects()
    // {
    //     return $this->belongsToMany(Subject::class)->withPivot('hours_per_week');
    // }

    // public function enrollments()
    // {
    //     return $this->hasMany(Enrollment::class);
    // }


    // public function teacherAssignments()
    // {
    //     return $this->hasMany(TeacherClassAssignment::class);
    // }

    // // public function evaluations()
    // // {
    // //     return $this->hasMany(Evaluation::class);
    // // }

    // public function attendances()
    // {
    //     return $this->hasMany(Attendance::class);
    // }

    // // Accesseurs
    // public function getFullNameAttribute()
    // {
    //     return $this->academicLevel->name . ' - ' . $this->name;
    // }
}
