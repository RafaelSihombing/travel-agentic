<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Flight;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookingsSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        $flights = Flight::all();

        Booking::create([
            'user_id' => $user->id,
            'flight_id' => $flights[1]->id,

            'booking_code' => 'BK-001',

            'contact_name' => 'Dina Nur Auliana',
            'contact_email' => 'dina@example.com',
            'contact_phone' => '081234567890',

            'passenger_count' => 1,

            'seat_class' => 'economy',

            'total_price' => 900000,

            'booking_status' => 'booked',

            'payment_status' => 'paid',
        ]);

        Booking::create([
            'user_id' => $user->id,
            'flight_id' => $flights[1]->id,

            'booking_code' => 'BK-002',

            'contact_name' => 'Budi Santoso',
            'contact_email' => 'budi@example.com',
            'contact_phone' => '081234567891',

            'passenger_count' => 2,

            'seat_class' => 'economy',

            'total_price' => 1800000,

            'booking_status' => 'booked',

            'payment_status' => 'paid',
        ]);

        Booking::create([
            'user_id' => $user->id,
            'flight_id' => $flights[0]->id,

            'booking_code' => 'BK-003',

            'contact_name' => 'Siti Aminah',
            'contact_email' => 'siti@example.com',
            'contact_phone' => '081234567892',

            'passenger_count' => 1,

            'seat_class' => 'business',

            'total_price' => 1500000,

            'booking_status' => 'booked',

            'payment_status' => 'paid',
        ]);
    }
}
