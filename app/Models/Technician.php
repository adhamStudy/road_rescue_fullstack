<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Technician extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'current_lat',
        'current_lng',
        'is_available',
        'status',
        'rating',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'is_available' => 'boolean',
        'current_lat' => 'double',
        'current_lng' => 'double',
        'rating' => 'decimal:2',
    ];

    // Relationships
    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class);
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    // Filament authentication - required by FilamentUser interface
    public function canAccessPanel(Panel $panel): bool
    {
        return $panel->getId() === 'technician' && $this->status === 'active';
    }
}
