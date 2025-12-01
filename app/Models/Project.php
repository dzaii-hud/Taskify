<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'assigned_to',
        'assigned_by',
        'name',
        'title',
        'description',
        'deadline',
        'progress',
        'status',
    ];

    /**
     * Owner (user) of the project
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * User yang diassign (opsional) — single column legacy
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Orang yang men-assign / pencipta (bisa admin atau owner)
     */
    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    /**
     * Relasi tasks
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'project_id');
    }

    /**
     * Relasi many-to-many: project assigned ke banyak user (pivot project_user)
     */
    public function assignedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_user')
            ->withPivot('assigned_by')
            ->withTimestamps();
    }

    public function getStatusAttribute()
    {
        $total = $this->tasks()->count();
        if ($total === 0) {
            return 'On Going';
        }

        $done  = $this->tasks()->where('status', 'done')->count();

        return $done === $total
            ? 'Done'
            : 'On Going';
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->attributes['title'] ?? $this->attributes['name'] ?? '-';
    }
}
