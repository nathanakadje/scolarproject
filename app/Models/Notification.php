<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Carbon\Carbon;

class Notification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'notifiable_id',
        'notifiable_type',
        'type',
        'title',
        'message',
        'data',
        'related_id',
        'related_type',
        'read_at',
        'priority',
        'icon',
        'color',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    /**
     * Priority levels.
     */
    const PRIORITY_LOW = 'low';
    const PRIORITY_NORMAL = 'normal';
    const PRIORITY_HIGH = 'high';
    const PRIORITY_URGENT = 'urgent';

    /**
     * Notification types.
     */
    const TYPE_CALENDAR_EVENT = 'calendar_event';
    const TYPE_ASSIGNMENT = 'assignment';
    const TYPE_GRADE = 'grade';
    const TYPE_ANNOUNCEMENT = 'announcement';
    const TYPE_SYSTEM = 'system';

    /**
     * Get the notifiable model (Student, Teacher, etc.).
     */
    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the related model (CalendarEvent, Assignment, etc.).
     */
    public function related(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope a query to only include notifications for a specific user.
     */
    public function scopeForUser(Builder $query, $userId): Builder
    {
        return $query->where('notifiable_id', $userId)
            ->where('notifiable_type', 'App\Models\Student');
    }

    /**
     * Scope a query to only include unread notifications.
     */
    public function scopeUnread(Builder $query): Builder
    {
        return $query->whereNull('read_at');
    }

    /**
     * Scope a query to only include read notifications.
     */
    public function scopeRead(Builder $query): Builder
    {
        return $query->whereNotNull('read_at');
    }

    /**
     * Scope a query to only include notifications by type.
     */
    public function scopeOfType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to only include notifications by priority.
     */
    public function scopeOfPriority(Builder $query, string $priority): Builder
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope a query to only include urgent notifications.
     */
    public function scopeUrgent(Builder $query): Builder
    {
        return $query->where('priority', self::PRIORITY_URGENT);
    }

    /**
     * Scope a query to only include recent notifications (last 30 days).
     */
    public function scopeRecent(Builder $query, int $days = 30): Builder
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Mark the notification as read.
     */
    public function markAsRead(): bool
    {
        if (is_null($this->read_at)) {
            return $this->update(['read_at' => now()]);
        }

        return false;
    }

    /**
     * Mark the notification as unread.
     */
    public function markAsUnread(): bool
    {
        if (!is_null($this->read_at)) {
            return $this->update(['read_at' => null]);
        }

        return false;
    }

    /**
     * Check if the notification is read.
     */
    public function isRead(): bool
    {
        return !is_null($this->read_at);
    }

    /**
     * Check if the notification is unread.
     */
    public function isUnread(): bool
    {
        return is_null($this->read_at);
    }

    /**
     * Get the priority color.
     */
    public function getPriorityColorAttribute(): string
    {
        return match ($this->priority) {
            self::PRIORITY_LOW => '#6B7280',    // gray
            self::PRIORITY_NORMAL => '#3B82F6', // blue
            self::PRIORITY_HIGH => '#F59E0B',   // yellow
            self::PRIORITY_URGENT => '#EF4444', // red
            default => '#3B82F6',
        };
    }

    /**
     * Get the priority badge class.
     */
    public function getPriorityBadgeClassAttribute(): string
    {
        return match ($this->priority) {
            self::PRIORITY_LOW => 'bg-gray-100 text-gray-800',
            self::PRIORITY_NORMAL => 'bg-blue-100 text-blue-800',
            self::PRIORITY_HIGH => 'bg-yellow-100 text-yellow-800',
            self::PRIORITY_URGENT => 'bg-red-100 text-red-800',
            default => 'bg-blue-100 text-blue-800',
        };
    }

    /**
     * Get the icon HTML or emoji.
     */
    public function getIconHtmlAttribute(): string
    {
        if ($this->icon) {
            return $this->icon;
        }

        // Icônes par défaut selon le type
        return match ($this->type) {
            self::TYPE_CALENDAR_EVENT => '📅',
            self::TYPE_ASSIGNMENT => '📝',
            self::TYPE_GRADE => '🎯',
            self::TYPE_ANNOUNCEMENT => '📢',
            self::TYPE_SYSTEM => '⚙️',
            default => '🔔',
        };
    }

    /**
     * Get the time ago format.
     */
    // public function getTimeAgoAttribute(): string
    // {
    //     return $this->created_at->diffForHumans();
    // }

    public function getTimeAgoAttribute(): string
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    /**
     * Get the notification action URL.
     */
    public function getActionUrlAttribute(): ?string
    {
        if (!$this->related_type || !$this->related_id) {
            return null;
        }

        return match ($this->related_type) {
            'App\Models\CalendarEvent' => route('student.calendar'),
            'App\Models\Assignment' => route('student.assignments', $this->related_id),
            'App\Models\Grade' => route('student.grades'),
            default => null,
        };
    }

    /**
     * Get the notification action label.
     */
    public function getActionLabelAttribute(): ?string
    {
        if (!$this->related_type) {
            return null;
        }

        return match ($this->related_type) {
            'App\Models\CalendarEvent' => 'Voir le calendrier',
            'App\Models\Assignment' => 'Voir le devoir',
            'App\Models\Grade' => 'Voir les notes',
            default => 'Voir les détails',
        };
    }

    /**
     * Create a new notification.
     */
    public static function createNotification(array $data): self
    {
        return self::create([
            'notifiable_id' => $data['notifiable_id'],
            'notifiable_type' => $data['notifiable_type'],
            'type' => $data['type'],
            'title' => $data['title'],
            'message' => $data['message'],
            'data' => $data['data'] ?? null,
            'related_id' => $data['related_id'] ?? null,
            'related_type' => $data['related_type'] ?? null,
            'priority' => $data['priority'] ?? self::PRIORITY_NORMAL,
            'icon' => $data['icon'] ?? null,
            'color' => $data['color'] ?? '#3B82F6',
        ]);
    }

    /**
     * Mark all notifications as read for a user.
     */
    public static function markAllAsReadForUser($userId, string $userType = 'App\Models\Student'): int
    {
        return self::where('notifiable_id', $userId)
            ->where('notifiable_type', $userType)
            ->unread()
            ->update(['read_at' => now()]);
    }

    /**
     * Get unread count for a user.
     */
    public static function getUnreadCountForUser($userId, string $userType = 'App\Models\Student'): int
    {
        return self::where('notifiable_id', $userId)
            ->where('notifiable_type', $userType)
            ->unread()
            ->count();
    }

    /**
     * Get notifications with pagination for a user.
     */
    public static function getForUser($userId, string $userType = 'App\Models\Student', int $perPage = 15)
    {
        return self::where('notifiable_id', $userId)
            ->where('notifiable_type', $userType)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Clean up old notifications (older than 90 days).
     */
    public static function cleanupOldNotifications(int $days = 90): int
    {
        return self::where('created_at', '<', now()->subDays($days))
            ->delete();
    }

    /**
     * Accesseur pour is_read
     */
    public function getIsReadAttribute(): bool
    {
        return !is_null($this->read_at);
    }

    /**
     * Accesseur pour time_ago
     */


    /**
     * Accesseur pour icon avec fallback
     */
    public function getIconAttribute($value): string
    {
        return $value ?? $this->getDefaultIcon();
    }

    private function getDefaultIcon(): string
    {
        return match ($this->type) {
            'calendar_event' => '📅',
            'assignment' => '📝',
            'grade' => '🎯',
            'announcement' => '📢',
            default => '🔔',
        };
    }

}