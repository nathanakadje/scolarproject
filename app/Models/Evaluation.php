<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Evaluation extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'name',
        'subject_id',
        'class_id',
        'academic_year_id',
        'teacher_id',
        'type',
        'date',
        'max_score',
        'duration_minutes',
        'description',
        'status'
    ];

    protected $casts = [
        'date' => 'date',
        'max_score' => 'decimal:2',
    ];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(ClassModel::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }
}
