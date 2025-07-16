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

    protected $casts = [
        'lat' => 'double',
        'lng' => 'double',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    public function bill()
    {
        return $this->hasOne(Bill::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeAssigned($query)
    {
        return $query->where('status', 'assigned');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Helper methods
    public function assignTechnician(Technician $technician)
    {
        $this->update([
            'technician_id' => $technician->id,
            'status' => 'assigned'
        ]);
    }

    public function markAsCompleted()
    {
        $this->update(['status' => 'completed']);

        // Create bill when request is completed
        $this->createBill();
    }

    public function createBill()
    {
        if ($this->bill) {
            return $this->bill; // Bill already exists
        }

        $isNightService = Bill::isNightTime($this->created_at);
        $nightTax = $isNightService ? ($this->service->price * 0.5) : 0; // 50% night surcharge

        return Bill::create([
            'user_id' => $this->user_id,
            'technician_id' => $this->technician_id,
            'service_id' => $this->service_id,
            'service_request_id' => $this->id,
            'base_price' => $this->service->price,
            'night_tax' => $nightTax,
            'total_amount' => $this->service->price + $nightTax,
            'is_night_service' => $isNightService,
            'status' => 'pending',
        ]);
    }
}
