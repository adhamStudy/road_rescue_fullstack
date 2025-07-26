<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserAccountController extends Controller
{
    public function create()
    {
        if (!Auth::user()) {
            return Inertia::render('Auth/Register');
        }
        return redirect()->intended('/');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => [
                'required',
                'string',
                'regex:/^5[0-9]{8}$/',
                'unique:users,phone'
            ],
            'password' => 'required|string|min:8|confirmed'
        ], [
            'phone.regex' => 'Phone number must be a valid Saudi mobile number (9 digits starting with 5).',
            'phone.unique' => 'This phone number is already registered.',
            'email.unique' => 'This email address is already registered.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.min' => 'Password must be at least 8 characters long.'
        ]);

        $fullPhoneNumber = '+966' . $validated['phone'];

        // Use DB::table instead of User::create to avoid the enum issue
        $userId = DB::table('users')->insertGetId([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $fullPhoneNumber,
            'password' => Hash::make($validated['password']),
            'role' => 'client', // This will be properly quoted
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = User::find($userId);
        Auth::login($user);

        return redirect()->intended('/');
    }
}
