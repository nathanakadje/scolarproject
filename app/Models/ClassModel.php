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
        return $this->belongsTo(AcademicLevel::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function teacherAssignments(): HasMany
    {
        return $this->hasMany(TeacherClassAssignment::class);
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
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

    // public function students()
    // {
    //     return $this->belongsToMany(Student::class, 'enrollments')->withPivot('academic_year_id', 'status');
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
