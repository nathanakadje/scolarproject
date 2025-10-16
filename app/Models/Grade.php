<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    //

    use HasFactory;

    protected $fillable = [
        'student_id',
        'evaluation_id',
        'score',
        'feedback',
        'graded_at',
        'graded_by'
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'graded_at' => 'datetime',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function evaluation(): BelongsTo
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function gradedBy(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'graded_by');
    }
    // protected $fillable = [
    //     'student_id',
    //     'evaluation_id',
    //     'score',
    //     'feedback',
    //     'graded_at',
    //     'graded_by'
    // ];

    // protected $casts = [
    //     'score' => 'decimal:2',
    //     'graded_at' => 'datetime',
    // ];

    // // Relations
    // public function student()
    // {
    //     return $this->belongsTo(Student::class);
    // }

    // // public function evaluation()
    // // {
    // //     return $this->belongsTo(Evaluation::class);
    // // }

    // public function gradedBy()
    // {
    //     return $this->belongsTo(Teacher::class, 'graded_by');
    // }

    // // Accesseurs
    // public function getPercentageAttribute()
    // {
    //     if ($this->evaluation->max_score == 0)
    //         return 0;
    //     return ($this->score / $this->evaluation->max_score) * 100;
    // }

    // public function getGradeLetterAttribute()
    // {
    //     $percentage = $this->percentage;
    //     if ($percentage >= 90)
    //         return 'A';
    //     if ($percentage >= 80)
    //         return 'B';
    //     if ($percentage >= 70)
    //         return 'C';
    //     if ($percentage >= 60)
    //         return 'D';
    //     return 'F';
    // }
}
