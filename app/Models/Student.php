<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Models\ParentModel;
use Carbon\Carbon;

class Student extends Model
{
    use HasFactory, InteractsWithMedia;

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
    protected $appends = ['age'];

    public function getAgeAttribute()
    {
        // Force la conversion en Carbon si ce n'est pas déjà fait
        $birth = $this->birth_date instanceof Carbon
            ? $this->birth_date
            : Carbon::parse($this->birth_date);

        return $birth ? $birth->age : null;
    }

    protected static function booted()
    {
        static::creating(function ($student) {
            if (empty($student->student_number)) {
                $student->student_number = 'STU' . now()->year . str_pad(Student::max('id') + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    // Relations
    public function parents(): BelongsToMany
    {
        return $this->belongsToMany(ParentModel::class, 'student_parent', 'student_id', 'parent_id')
            ->withPivot('is_primary_contact')
            ->withTimestamps();
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
    public function getAttendanceRateAttribute(): float
    {
        $total = $this->attendances()->count();

        if ($total === 0) {
            return 0;
        }

        $presentCount = $this->attendances()
            ->where('status', 'present')
            ->count();

        return round(($presentCount / $total) * 100, 2);
    }

    // Méthodes utilitaires
    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getCurrentEnrollment()
    {
        return $this->enrollments()
            ->whereHas('academicYear', function ($query) {
                $query->where('is_current', true);
            })
            ->first();
    }
    public function academicYears()
    {
        return $this->belongsToMany(
            AcademicYear::class,
            'enrollments',
            'student_id',
            'academic_year_id'
        )->withPivot('class_id', 'status');
    }
    public function classe(): BelongsTo
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function resources()
    {
        return $this->belongsToMany(Resource::class, 'resource_student')->withTimestamps();
    }

    public function resourceNotifications()
    {
        return $this->hasMany(ResourceNotification::class);
    }
    public function assignmentSubmissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    public function assignmentGroups()
    {
        return $this->belongsToMany(AssignmentGroup::class, 'assignment_group_members');
    }

    public function peerReviews()
    {
        return $this->hasMany(PeerReview::class, 'reviewer_id');
    }
}
