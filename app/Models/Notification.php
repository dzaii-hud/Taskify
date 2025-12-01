<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /**
     * Default attribute values to avoid DB errors when some fields
     * aren't explicitly provided by the creator code.
     *
     * - 'type' required by your migration -> default to 'generic'
     * - 'is_read' default false
     */
    protected $attributes = [
        'type'    => 'generic',
        'is_read' => false,
    ];

    /**
     * Fields that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'task_id',
        'is_read',
        'action_url', // optional helpful field if you want a CTA link
    ];

    /**
     * Casts
     */
    protected $casts = [
        'is_read'    => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relations
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function task()
    {
        return $this->belongsTo(\App\Models\Task::class);
    }

    /**
     * Scope: unread notifications
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope: for specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
