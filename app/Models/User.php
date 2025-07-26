<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should have default values.
     *
     * @var array
     */
    protected $attributes = [
        'role' => 'client',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => 'string',
        ];
    }

    /**
     * Determine if the user can access the given Filament panel.
     *
     * @param Panel $panel
     * @return bool
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Allow access to admin panel only for admin users
        if ($panel->getId() === 'admin') {
            return $this->isAdmin();
        }


        // Default: deny access
        return false;
    }

    /**
     * Check if user is admin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is client
     *
     * @return bool
     */
    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    /**
     * Scope to get only admin users
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope to get only client users
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeClients($query)
    {
        return $query->where('role', 'client');
    }

    /**
     * Get role badge color for display
     *
     * @return string
     */
    public function getRoleBadgeColorAttribute(): string
    {
        return match ($this->role) {
            'admin' => 'danger',
            'client' => 'success',
            default => 'gray'
        };
    }

    /**
     * Get formatted role name for display
     *
     * @return string
     */
    public function getFormattedRoleAttribute(): string
    {
        return ucfirst($this->role);
    }

    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class);
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
}
