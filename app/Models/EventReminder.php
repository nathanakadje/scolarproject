<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class EventReminder extends Model
{
    //
    protected $fillable = [
        'event_id',
        'user_id',
        'remind_at',
        'is_sent',
        'sent_at'
    ];

    protected $casts = [
        'remind_at' => 'datetime',
        'sent_at' => 'datetime',
        'is_sent' => 'boolean',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(CalendarEvent::class, 'event_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopePending($query)
    {
        return $query->where('is_sent', false)
            ->where('remind_at', '<=', now());
    }
}
