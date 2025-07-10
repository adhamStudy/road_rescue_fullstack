<?php

use App\Http\Controllers\SMSController;
use Illuminate\Support\Facades\Route;

Route::post('/send-sms', [SMSController::class, 'send']);
