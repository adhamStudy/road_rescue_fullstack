<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});

Route::get('/services', function () {

    return Inertia::render('Services');
});
Route::get('/register', function () {

    return Inertia::render('Auth/Register');
});

Route::get('/login', [AuthController::class, 'create'])->name('login');
Route::post('/login', [AuthController::class, 'store'])->name('login.store');
Route::delete('/signout', [AuthController::class, 'destroy'])->name('signout');
