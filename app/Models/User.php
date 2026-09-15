<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    use HasFactory, Notifiable, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'foto',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * =========================================================
     * ACTIVITY LOG CONFIGURATION
     * =========================================================
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'role'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * =========================================================
     * ACCESSORS
     * =========================================================
     */

    /**
     * Get the user's foto URL
     */
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return null;
    }

    /**
     * Get the user's role label
     */
    public function getRoleLabelAttribute()
    {
        return match($this->role) {
            'super_admin' => 'Super Admin',
            'admin' => 'Admin',
            'editor' => 'Editor',
            'publisher' => 'Publisher',
            default => ucfirst($this->role),
        };
    }

    /**
     * Get the user's role badge color
     */
    public function getRoleBadgeColorAttribute()
    {
        return match($this->role) {
            'super_admin' => 'bg-purple-50 text-purple-700',
            'admin' => 'bg-blue-50 text-blue-700',
            'editor' => 'bg-yellow-50 text-yellow-700',
            'publisher' => 'bg-green-50 text-green-700',
            default => 'bg-gray-50 text-gray-500',
        };
    }

    /**
     * =========================================================
     * CHECK METHODS
     * =========================================================
     */

    /**
     * Check if user is Super Admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * Check if user is Admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is Editor
     */
    public function isEditor(): bool
    {
        return $this->role === 'editor';
    }

    /**
     * Check if user is Publisher
     */
    public function isPublisher(): bool
    {
        return $this->role === 'publisher';
    }

    /**
     * Check if user has admin-level access (Super Admin or Admin)
     */
    public function isAdminLevel(): bool
    {
        return in_array($this->role, ['super_admin', 'admin']);
    }

    /**
     * Check if user can manage content (Super Admin, Admin, or Editor)
     */
    public function canManageContent(): bool
    {
        return in_array($this->role, ['super_admin', 'admin', 'editor']);
    }

    /**
     * Check if user can publish content (Super Admin, Admin, or Publisher)
     */
    public function canPublishContent(): bool
    {
        return in_array($this->role, ['super_admin', 'admin', 'publisher']);
    }

    /**
     * =========================================================
     * RELATIONSHIPS
     * =========================================================
     */

    /**
     * Get all berita authored by this user
     */
    public function berita()
    {
        return $this->hasMany(Berita::class, 'penulis', 'name');
    }

    /**
     * Get activities caused by this user
     */
    public function activities()
    {
        return $this->hasMany(\Spatie\Activitylog\Models\Activity::class, 'causer_id');
    }
}