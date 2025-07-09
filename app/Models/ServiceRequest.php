<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'technician_id',
        'lat',
        'lng',
        'vehicle_type',
        'vehicle_model',
        'issue_description',
        'status',
    ];

    /**
     * The user who made the request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The service being requested.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * The technician assigned to fulfill the request.
     */
    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    /**
     * The bill associated with this service request (if you have a Bill model).
     */
    // public function bill()
    // {
    //     return $this->hasOne(Bill::class);
    // }
}
