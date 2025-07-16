<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'service_type',
    ];

    protected $casts = [
        'price' => 'decimal:2',
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

    // Scopes
    public function scopeByType($query, $type)
    {
        return $query->where('service_type', $type);
    }

    // Helper methods
    public function getFormattedPriceAttribute()
    {
        return 'SAR ' . number_format($this->price, 2);
    }
}
