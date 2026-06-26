<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UsersSeeder::class,
            AirlinesSeeder::class,
            AirportsSeeder::class,
            FlightsSeeder::class,
            FlightStatusSeeder::class,

            BookingsSeeder::class,

            BookingPassengersSeeder::class,

            AlternativeFlightsSeeder::class,
        ]);
    }
}
