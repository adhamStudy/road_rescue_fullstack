<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserAccountController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});

Route::get('/services', function () {

    return Inertia::render('Services');
})->middleware(
    'auth'
);



Route::get('/login', [AuthController::class, 'create'])->name('login');
Route::post('/login', [AuthController::class, 'store'])->name('login.store');
Route::delete('/logout', [AuthController::class, 'destroy'])->name('logout');


Route::get(
    '/register',
    [UserAccountController::class, 'create']
)->name('register');
Route::post('/register', [UserAccountController::class, 'store']);
