<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Teacher extends Model
{
    //
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'teacher_number',
        'first_name',
        'last_name',
        'birth_date',
        'gender',
        'phone',
        'email',
        'address',
        'qualification',
        'hire_date',
        'salary',
        'status',
        'photo',
        'specializations'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'hire_date' => 'date',
        'salary' => 'decimal:2',
        'specializations' => 'array',
    ];

    public function classAssignments(): HasMany
    {
        return $this->hasMany(TeacherClassAssignment::class);
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }

    public function attendanceMarked(): HasMany
    {
        return $this->hasMany(Attendance::class, 'marked_by');
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    //     use HasFactory;

    //     protected $fillable = [
//         'teacher_number',
//         'first_name',
//         'last_name',
//         'birth_date',
//         'gender',
//         'phone',
//         'email',
//         'address',
//         'qualification',
//         'hire_date',
//         'salary',
//         'status',
//         'photo',
//         'specializations'
//     ];

    //     protected $casts = [
//         'birth_date' => 'date',
//         'hire_date' => 'date',
//         'salary' => 'decimal:2',
//         'specializations' => 'array',
//     ];

    //     // Relations
//     public function classAssignments()
//     {
//         return $this->hasMany(TeacherClassAssignment::class);
//     }

    //     public function classes()
//     {
//         return $this->belongsToMany(ClassModel::class, 'teacher_class_assignments')
//             ->withPivot('subject_id', 'academic_year_id', 'is_main_teacher');
//     }

    //     public function subjects()
//     {
//         return $this->belongsToMany(Subject::class, 'teacher_class_assignments')
//             ->withPivot('class_id', 'academic_year_id');
//     }

    //     // public function evaluations()
//     // {
//     //     return $this->hasMany(Evaluation::class);
//     // }

    //     // public function attendancesMarked()
//     // {
//     //     return $this->hasMany(Attendance::class, 'marked_by');
//     // }

    //     // public function gradesGiven()
//     // {
//     //     return $this->hasMany(Grade::class, 'graded_by');
//     // }

    //     // Accesseurs
//     public function getFullNameAttribute()
//     {
//         return $this->first_name . ' ' . $this->last_name;
//     }
}
