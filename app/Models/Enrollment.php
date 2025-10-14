<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enrollment extends Model
{
    //

    use HasFactory;
    protected $fillable = [
        'student_id',
        'class_id',
        'academic_year_id',
        'enrollment_date',
        'fees_paid',
        'fees_due',
        'status',
        'notes'
    ];

    protected $casts = [
        'enrollment_date' => 'date',
        'fees_paid' => 'decimal:2',
        'fees_due' => 'decimal:2',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }
    // protected $fillable = [
    //     'student_id',
    //     'class_id',
    //     'academic_year_id',
    //     'enrollment_date',
    //     'fees_paid',
    //     'fees_due',
    //     'status',
    //     'notes'
    // ];

    // protected $casts = [
    //     'enrollment_date' => 'date',
    //     'fees_paid' => 'decimal:2',
    //     'fees_due' => 'decimal:2',
    // ];

    // // Relations
    // public function student()
    // {
    //     return $this->belongsTo(Student::class);
    // }

    // public function class()
    // {
    //     return $this->belongsTo(ClassModel::class);
    // }

    // public function academicYear()
    // {
    //     return $this->belongsTo(AcademicYear::class);
    // }

    // // Accesseurs
    // public function getRemainingFeesAttribute()
    // {
    //     return $this->fees_due - $this->fees_paid;
    // }

    // public function getPaymentProgressAttribute()
    // {
    //     if ($this->fees_due == 0)
    //         return 100;
    //     return ($this->fees_paid / $this->fees_due) * 100;
    // }
}
