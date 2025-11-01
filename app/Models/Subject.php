<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'coefficient',
        'color',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }

    public function teacherAssignments(): HasMany
    {
        return $this->hasMany(TeacherClassAssignment::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
    // use Ha
    // sFactory;

    // protected $fillable = [
    //     'name',
    //     'code',
    //     'description',
    //     'coefficient',
    //     'color',
    //     'is_active'
    // ];

    // protected $casts = [
    //     'is_active' => 'boolean',
    // ];

    // // Relations
    // public function classes()
    // {
    //     return $this->belongsToMany(ClassModel::class)->withPivot('hours_per_week');
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
}
