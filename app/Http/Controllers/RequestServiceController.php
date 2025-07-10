<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Add this import
use Inertia\Inertia;

class RequestServiceController extends Controller
{
    public function create()
    {
        $services = Service::all();
        return Inertia::render('RequestService/RequestService', ['services' => $services]);
    }

    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'vehicle_type' => 'required|string|max:255',
            'vehicle_model' => 'required|string|max:255',
            'issue_description' => 'nullable|string',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        // Create the request
        $serviceRequest = ServiceRequest::create([
            'user_id' => Auth::id(),
            'service_id' => $validated['service_id'],
            'vehicle_type' => $validated['vehicle_type'],
            'vehicle_model' => $validated['vehicle_model'],
            'issue_description' => $validated['issue_description'],
            'lat' => $validated['lat'],
            'lng' => $validated['lng'],
            'status' => 'pending',
        ]);

        // Debug: Check if record is created
        Log::info('Service request created with ID: ' . $serviceRequest->id);

        // Redirect to acknowledgment page with request ID
        return redirect()->route('service-requests.acknowledgment', $serviceRequest->id);
    }

    // Step 2: Add a new method to show the acknowledgment page
    public function acknowledgment($id)
    {
        $serviceRequest = ServiceRequest::with('service')->findOrFail($id);

        // Make sure the user can only view their own requests
        if ($serviceRequest->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return Inertia::render('RequestService/Acknowledgment', [
            'serviceRequest' => $serviceRequest
        ]);
    }
    public function checkStatus($id)
    {
        $serviceRequest = ServiceRequest::findOrFail($id);

        // Make sure the user can only view their own requests
        if ($serviceRequest->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Load the service relationship
        $serviceRequest->load('service');

        // Return the updated service request data with the same acknowledgment page
        return Inertia::render('RequestService/Acknowledgment', [
            'serviceRequest' => $serviceRequest
        ]);
    }
}
