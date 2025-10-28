<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
class Resource extends Model
{
    //
    protected $fillable = [
        'teacher_id',
        'resource_category_id',
        'subject_id',
        'title',
        'description',
        'type',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'url',
        'link_type',
        'tags',
        'access_level',
        'allow_download',
        'download_count',
        'view_count',
        'is_featured',
        'is_active',
        'published_at',
    ];

    protected $casts = [
        'tags' => 'array',
        'published_at' => 'datetime',
        'allow_download' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ResourceCategory::class, 'resource_category_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(ClassModel::class, 'resource_class', 'resource_id', 'class_id')
            ->withTimestamps();
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'resource_student')
            ->withTimestamps();
    }

    public function views(): HasMany
    {
        return $this->hasMany(ResourceView::class);
    }

    public function downloads(): HasMany
    {
        return $this->hasMany(ResourceDownload::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(ResourceNotification::class);
    }

    public function getFileSizeHumanAttribute(): string
    {
        if (!$this->file_size)
            return 'N/A';

        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = $this->file_size;
        $i = 0;

        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getFileIconAttribute(): string
    {
        return match ($this->file_type) {
            'pdf' => '📄',
            'doc', 'docx' => '📝',
            'xls', 'xlsx' => '📊',
            'ppt', 'pptx' => '📽️',
            'jpg', 'jpeg', 'png', 'gif' => '🖼️',
            'mp4', 'avi', 'mov' => '🎥',
            'mp3', 'wav' => '🎵',
            'zip', 'rar' => '📦',
            default => '📎'
        };
    }

    public function getTypeIconAttribute(): string
    {
        return match ($this->type) {
            'file' => '📁',
            'link' => '🔗',
            'video' => '🎬',
            'article' => '📰',
            default => '📄'
        };
    }

    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }

    public function incrementDownloadCount(): void
    {
        $this->increment('download_count');
    }

    public function getDownloadUrl(): string
    {
        if ($this->type === 'file' && $this->file_path) {
            return Storage::url($this->file_path);
        }
        return $this->url ?? '#';
    }
}
