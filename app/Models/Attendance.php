<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Student;
use App\Models\ClassModel;
use App\Models\Subject;
use App\Models\Teacher;
class Attendance extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'student_id',
        'class_id',
        'subject_id',
        'date',
        'status',
        'reason',
        'is_justified',
        'marked_by'
    ];

    protected $casts = [
        'date' => 'date',
        'is_justified' => 'boolean',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(ClassModel::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function markedBy(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'marked_by');
    }
    // protected $fillable = [
    //     'student_id',
    //     'class_id',
    //     'subject_id',
    //     'date',
    //     'status',
    //     'reason',
    //     'is_justified',
    //     'marked_by'
    // ];

    // protected $casts = [
    //     'date' => 'date',
    //     'is_justified' => 'boolean',
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

    // public function subject()
    // {
    //     return $this->belongsTo(Subject::class);
    // }

    // public function markedBy()
    // {
    //     return $this->belongsTo(Teacher::class, 'marked_by');
    // }
}
