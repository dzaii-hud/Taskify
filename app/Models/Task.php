<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'assigned_to',
        'assigned_by',
        'title',
        'description',
        'status',
        'deadline',
        'priority',
        'completion_note',
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /** Relasi ke project */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /** Relasi ke user yang ditugaskan */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /** Relasi ke user yang menugaskan (creator / assigner) */
    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    /** Accessor label status */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'on_going', 'ongoing', 'in_progress', 'in-progress' => 'On Going',
            'done', 'completed', 'finished', 'complete' => 'Done',
            default => ucfirst(str_replace('_', ' ', $this->status ?? 'on_going')),
        };
    }

    /** Normalized status */
    public function getNormalizedStatusAttribute(): string
    {
        $s = strtolower(trim($this->status ?? ''));

        if (in_array($s, ['done', 'completed', 'finished', 'complete'])) {
            return 'done';
        }

        return 'on_going';
    }

    /** Display name for title */
    public function getDisplayNameAttribute(): string
    {
        return $this->attributes['title'] ?? $this->attributes['name'] ?? '-';
    }

    /**
     * Helper: apakah current user dapat modify (edit/delete) this task?
     * Business rule: hanya user yang menugaskan (assigned_by) yang bisa edit/delete
     */
    public function canBeModifiedByUserId(int $userId): bool
    {
        return (int)$this->assigned_by === (int)$userId;
    }
}
