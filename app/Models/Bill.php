<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'technician_id',
        'service_id',
        'service_request_id',
        'base_price',
        'night_tax',
        'total_amount',
        'is_night_service',
        'status',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'night_tax' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'is_night_service' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    // Helper method to calculate total
    public function calculateTotal()
    {
        $this->total_amount = $this->base_price + $this->night_tax;
        return $this->total_amount;
    }

    // Check if service is during night hours (10 PM - 6 AM)
    public static function isNightTime($dateTime = null)
    {
        $time = $dateTime ? $dateTime : now();
        $hour = $time->format('H');
        return $hour >= 22 || $hour < 6;
    }
}
