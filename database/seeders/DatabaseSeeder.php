<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Airport;
use App\Models\Terminal;
use App\Models\Supplier;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Heathrow airport
        $heathrow = Airport::create([
            'name' => 'Heathrow',
            'code' => 'LHR',
        ]);

        // Create four terminals for Heathrow
        $terminals = [
            Terminal::create(['airport_id' => $heathrow->id, 'name' => 'Terminal 2']),
            Terminal::create(['airport_id' => $heathrow->id, 'name' => 'Terminal 3']),
            Terminal::create(['airport_id' => $heathrow->id, 'name' => 'Terminal 4']),
            Terminal::create(['airport_id' => $heathrow->id, 'name' => 'Terminal 5']),
        ];

        // Create the single service: Park & Ride
        $service = Service::create([
            'name' => 'Park & Ride',
            'description' => 'Convenient parking with shuttle service to the terminal.',
            'badge' => 'park-ride',
            'features' => 'Shuttle, Secure Parking, 24/7 Access',
        ]);

        // Create suppliers for Heathrow
        Supplier::factory()->count(10)->create([
            'airport_id' => $heathrow->id,
        ]);

        // Create bookings for Heathrow
        Booking::factory()->count(1000)->create([
            'airport_id' => $heathrow->id,
            'service_id' => $service->id,
            'departure_terminal_id' => $terminals[array_rand($terminals)]->id,
            'arrival_terminal_id' => $terminals[array_rand($terminals)]->id,
        ]);

        User::factory()->create([
            'first_name' => 'Hassan Raza',
            'last_name' => 'Pasha',
            'email' => 'pasha@test.com',
            'password' => bcrypt('password'),
        ]);
    }
}
