<?php

namespace Database\Seeders;

use App\Models\Technician;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TechnicianSeeder extends Seeder
{
    public function run(): void
    {
        Technician::create([
            'name' => 'Ahmed Al-Salem',
            'email' => 'ahmed@rescueroad.com',
            'phone' => '966501234567',
            'password' => Hash::make('password'),
            'current_lat' => 24.7136,
            'current_lng' => 46.6753,
            'is_available' => true,
            'status' => 'active',
            'rating' => 4.5,
        ]);

        Technician::create([
            'name' => 'Mohammed Al-Rashid',
            'email' => 'mohammed@rescueroad.com',
            'phone' => '966501234568',
            'password' => Hash::make('password'),
            'current_lat' => 24.7236,
            'current_lng' => 46.6853,
            'is_available' => true,
            'status' => 'active',
            'rating' => 4.8,
        ]);

        Technician::create([
            'name' => 'Khalid Al-Otaibi',
            'email' => 'khalid@rescueroad.com',
            'phone' => '966501234569',
            'password' => Hash::make('password'),
            'current_lat' => 24.6936,
            'current_lng' => 46.6553,
            'is_available' => false,
            'status' => 'active',
            'rating' => 4.2,
        ]);

        Technician::create([
            'name' => 'Omar Al-Zahrani',
            'email' => 'omar@rescueroad.com',
            'phone' => '966501234570',
            'password' => Hash::make('password'),
            'current_lat' => 24.7436,
            'current_lng' => 46.7053,
            'is_available' => true,
            'status' => 'active',
            'rating' => 4.9,
        ]);

        Technician::create([
            'name' => 'Abdullah Al-Harbi',
            'email' => 'abdullah@rescueroad.com',
            'phone' => '966501234571',
            'password' => Hash::make('password'),
            'current_lat' => 24.6836,
            'current_lng' => 46.6453,
            'is_available' => true,
            'status' => 'inactive',
            'rating' => 3.8,
        ]);
    }
}
