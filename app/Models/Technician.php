<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'is_available',
        'rating',
    ];

    /**
     * Get all service requests assigned to this technician.
     */
    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class);
    }

    /**
     * Get all bills associated with this technician (optional if you have a Bill model).
     */
    // public function bills()
    // {
    //     return $this->hasMany(Bill::class);
    // }
}
