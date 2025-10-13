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
        'user_id',
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
    /*
    User relation (one-to-one) add user_id in teachers table
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /*
        Classe relation teacher can be multiple classes
    */
    public function classAssignments(): HasMany
    {
        return $this->hasMany(TeacherClassAssignment::class, 'teacher_id');
    }

    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'teacher_class_assignments', 'teacher_id', 'class_id')
            ->withPivot('subject_id', 'academic_year_id', 'is_main_teacher')
            ->withTimestamps();
    }
    public function getCurrentClasses()
    {
        return $this->classes()->get(); // simple récupération
    }


    /*
        User relation (one-to-one) add user_id in teachers table
    */

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'teacher_class_assignments', 'teacher_id', 'subject_id')
            ->withPivot('class_id', 'academic_year_id');
    }

    public function getSubjectsForClass($classId)
    {
        // Récupérer la liste d'IDs de subjects depuis le pivot
        $subjectIds = $this->classes()
            ->where('class_id', $classId)
            ->withPivot('subject_id')
            ->get()
            ->pluck('pivot.subject_id')
            ->unique()
            ->toArray();

        // Charger les objets Subject correspondants
        return Subject::whereIn('id', $subjectIds)->get();
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }

    public function attendanceMarked(): HasMany
    {
        return $this->hasMany(Attendance::class, 'marked_by');
    }
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
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
