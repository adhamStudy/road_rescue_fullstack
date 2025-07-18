<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class ServiceRequestStatusController extends Controller
{
    /**
     * Get the current status of a service request
     */
    public function getStatus(ServiceRequest $serviceRequest)
    {
        // Load the service request with related data
        $serviceRequest->load(['technician', 'service', 'user']);

        return response()->json([
            'id' => $serviceRequest->id,
            'status' => $serviceRequest->status,
            'technician' => $serviceRequest->technician ? [
                'id' => $serviceRequest->technician->id,
                'name' => $serviceRequest->technician->name,
                'phone' => $serviceRequest->technician->phone,
                'rating' => $serviceRequest->technician->rating,
                'is_available' => $serviceRequest->technician->is_available,
            ] : null,
            'service' => [
                'name' => $serviceRequest->service->name,
                'price' => $serviceRequest->service->price,
            ],
            'updated_at' => $serviceRequest->updated_at,
            'created_at' => $serviceRequest->created_at,
        ]);
    }

    /**
     * Get detailed status with additional information
     */
    public function getDetailedStatus(ServiceRequest $serviceRequest)
    {
        $serviceRequest->load(['technician', 'service', 'user', 'bill']);

        return response()->json([
            'id' => $serviceRequest->id,
            'status' => $serviceRequest->status,
            'vehicle_type' => $serviceRequest->vehicle_type,
            'vehicle_model' => $serviceRequest->vehicle_model,
            'issue_description' => $serviceRequest->issue_description,
            'lat' => $serviceRequest->lat,
            'lng' => $serviceRequest->lng,
            'technician' => $serviceRequest->technician ? [
                'id' => $serviceRequest->technician->id,
                'name' => $serviceRequest->technician->name,
                'phone' => $serviceRequest->technician->phone,
                'rating' => $serviceRequest->technician->rating,
                'current_lat' => $serviceRequest->technician->current_lat,
                'current_lng' => $serviceRequest->technician->current_lng,
                'is_available' => $serviceRequest->technician->is_available,
            ] : null,
            'service' => [
                'id' => $serviceRequest->service->id,
                'name' => $serviceRequest->service->name,
                'description' => $serviceRequest->service->description,
                'price' => $serviceRequest->service->price,
                'service_type' => $serviceRequest->service->service_type,
            ],
            'bill' => $serviceRequest->bill ? [
                'id' => $serviceRequest->bill->id,
                'total_amount' => $serviceRequest->bill->total_amount,
                'status' => $serviceRequest->bill->status,
                'is_night_service' => $serviceRequest->bill->is_night_service,
                'night_tax' => $serviceRequest->bill->night_tax,
                'base_price' => $serviceRequest->bill->base_price,
            ] : null,
            'user' => [
                'name' => $serviceRequest->user->name,
                'phone' => $serviceRequest->user->phone,
                'email' => $serviceRequest->user->email,
            ],
            'created_at' => $serviceRequest->created_at,
            'updated_at' => $serviceRequest->updated_at,
        ]);
    }

    /**
     * Update service request status (for testing purposes)
     */
    public function updateStatus(Request $request, ServiceRequest $serviceRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,assigned,completed,cancelled',
            'technician_id' => 'nullable|exists:technicians,id',
        ]);

        $serviceRequest->update($validated);

        return response()->json([
            'message' => 'Status updated successfully',
            'service_request' => $serviceRequest->load(['technician', 'service']),
        ]);
    }
}
