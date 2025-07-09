<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Towing Service',
                'description' => 'Tow any vehicle within a 50km radius to a safe location or garage.',
                'price' => 50.00,
                'service_type' => 'towing',
            ],
            [
                'name' => 'Battery Jump Start',
                'description' => 'Quick jump start to revive your dead car battery on site.',
                'price' => 20.00,
                'service_type' => 'battery_jump',
            ],
            [
                'name' => 'Fuel Delivery',
                'description' => 'Deliver up to 10 liters of fuel to your vehicle when you run out.',
                'price' => 25.00,
                'service_type' => 'fuel_delivery',
            ],
            [
                'name' => 'Tire Change',
                'description' => 'Replace or fix a flat tire quickly to get you back on the road.',
                'price' => 30.00,
                'service_type' => 'tire_change',
            ],
            [
                'name' => 'Lockout Service',
                'description' => 'Help you regain access if you are locked out of your vehicle.',
                'price' => 15.00,
                'service_type' => 'lockout',
            ],
            [
                'name' => 'Winching Service',
                'description' => 'Pull your vehicle out if stuck in mud, sand, or snow.',
                'price' => 40.00,
                'service_type' => 'winching',
            ],
            [
                'name' => 'Mechanical Assistance',
                'description' => 'Basic mechanical help at the roadside to get your vehicle running.',
                'price' => 60.00,
                'service_type' => 'mechanical',
            ],
            [
                'name' => 'Accident Assistance',
                'description' => 'Comprehensive help after an accident including towing and police coordination.',
                'price' => 100.00,
                'service_type' => 'accident_assist',
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['service_type' => $service['service_type']],
                $service
            );
        }
    }
}
