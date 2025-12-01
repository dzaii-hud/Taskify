<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // cek apakah admin
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // relasi user -> projects (yang dia buat / owner)
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'owner_id');
    }

    // relasi user -> tasks assigned (assigned_to)
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    /**
     * Jika project diassign via pivot (many-to-many)
     * User bisa mendapat banyak proyek lewat pivot project_user
     */
    public function assignedProjects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_user')
            ->withPivot('assigned_by')
            ->withTimestamps();
    }

    /**
     * Safety accessor untuk created_at agar blade tidak error saat null.
     */
    public function getReadableCreatedAtAttribute(): string
    {
        if ($this->created_at === null) {
            return '-';
        }

        try {
            return Carbon::parse($this->created_at)->diffForHumans();
        } catch (\Exception $e) {
            return (string) $this->created_at;
        }
    }
}
