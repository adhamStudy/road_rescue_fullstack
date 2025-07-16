<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Technician extends Authenticatable
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

    // Filament authentication
    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return $panel->getId() === 'technician' && $this->status === 'active';
    }
}
