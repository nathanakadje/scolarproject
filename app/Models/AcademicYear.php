<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicYear extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'is_current',
        'is_active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
        'is_active' => 'boolean',
    ];

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
    // use HasFactory;

    // protected $fillable = [
    //     'name',
    //     'start_date',
    //     'end_date',
    //     'is_current',
    //     'is_active'
    // ];

    // protected $casts = [
    //     'start_date' => 'date',
    //     'end_date' => 'date',
    //     'is_current' => 'boolean',
    //     'is_active' => 'boolean',
    // ];

    // // Relations
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

    // // public function payments()
    // // {
    // //     return $this->hasMany(Payment::class);
    // // }

    // // Scope pour année courante
    // public function scopeCurrent($query)
    // {
    //     return $query->where('is_current', true);
    // }
}
