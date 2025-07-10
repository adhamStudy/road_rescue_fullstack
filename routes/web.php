<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RequestServiceController;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\UserAccountController;
use App\Models\Service;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});

Route::get('/services', function () {

    $services = Service::all();
    // dd($services);

    return Inertia::render('Services', ['services' => $services]);
});



Route::get('/login', [AuthController::class, 'create'])->name('login');
Route::post('/login', [AuthController::class, 'store'])->name('login.store');
Route::delete('/logout', [AuthController::class, 'destroy'])->name('logout');


Route::get(
    '/register',
    [UserAccountController::class, 'create']
)->name('register');
Route::post('/register', [UserAccountController::class, 'store']);



// Request Service Controller 

Route::get('/request-service', [RequestServiceController::class, 'create'])->middleware('auth');
Route::post('/request-service', [RequestServiceController::class, 'store'])->middleware('auth');

Route::middleware(['auth'])->group(function () {
    // Existing routes...

    // Service request routes
    Route::get('/service-requests/{id}/acknowledgment', [RequestServiceController::class, 'acknowledgment'])
        ->name('service-requests.acknowledgment');

    // Add a regular web route for status updates
    Route::get('/service-requests/{id}/check-status', [RequestServiceController::class, 'checkStatus'])
        ->name('service-requests.check-status');

    // Other routes...
});
