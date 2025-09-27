<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Student extends Model
{
    //
    use CrudTrait;
    use HasFactory;
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'student_number',
        'first_name',
        'last_name',
        'birth_date',
        'birth_place',
        'gender',
        'nationality',
        'phone',
        'email',
        'address',
        'photo',
        'enrollment_date',
        'status',
        'medical_info',
        'notes'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'enrollment_date' => 'date',
    ];

    // Relations
    public function parents()
    {
        return $this->belongsToMany(ParentModel::class, 'student_parent', 'student_id', 'parent_id')
            ->withPivot('is_primary_contact');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function currentEnrollment()
    {
        return $this->hasOne(Enrollment::class)
            ->whereHas('academicYear', fn($q) => $q->where('is_current', true));
    }

    // public function classes()
    // {
    //     return $this->belongsToMany(ClassModel::class, 'enrollments')
    //         ->withPivot('academic_year_id', 'status');
    // }

    // public function grades()
    // {
    //     return $this->hasMany(Grade::class);
    // }

    // public function attendances()
    // {
    //     return $this->hasMany(Attendance::class);
    // }

    // public function payments()
    // {
    //     return $this->hasMany(Payment::class);
    // }

    // Accesseurs
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    // public function getAgeAttribute()
    // {
    //     return $this->birth_date->age;
    // }
}
