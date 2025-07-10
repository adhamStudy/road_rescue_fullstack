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
        return Inertia::render('RequestService', ['services' => $services]);
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
        ServiceRequest::create([
            'user_id' => Auth::id(),
            'service_id' => $validated['service_id'],
            'vehicle_type' => $validated['vehicle_type'],
            'vehicle_model' => $validated['vehicle_model'],
            'issue_description' => $validated['issue_description'],
            'lat' => $validated['lat'],
            'lng' => $validated['lng'],
            'status' => 'pending',
        ]);
        $lat = $validated['lat'];
        $lng = $validated['lng'];

        // Debug: Check if flash is being set
        Log::info('Setting flash message');

        return redirect()->back()->with('success', "We received your request at this dimensions ($lat,$lng)\nwe will send a Technician soon .. please be patient");
    }
}
