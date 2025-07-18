<?php

use App\Http\Controllers\SMSController;
use Illuminate\Support\Facades\Route;

Route::post('/send-sms', [SMSController::class, 'send']);


use App\Http\Controllers\ServiceRequestStatusController;

// Get current status
Route::get('/service-requests/{serviceRequest}/status', [ServiceRequestStatusController::class, 'getStatus']);

// Get detailed status (optional - for more comprehensive data)
Route::get('/service-requests/{serviceRequest}/detailed-status', [ServiceRequestStatusController::class, 'getDetailedStatus']);

// Update status (optional - for testing)
Route::put('/service-requests/{serviceRequest}/status', [ServiceRequestStatusController::class, 'updateStatus']);
