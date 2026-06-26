<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\BookingPassenger;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookingPassengersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $booking = Booking::first();

        if (!$booking) {
            return;
        }

        BookingPassenger::create([
            'id' => Str::uuid(),
            'booking_id' => $booking->id,
            'title' => 'Ms',
            'full_name' => 'Dina Nur Auliana',
            'date_of_birth' => '2001-05-10',
            'nationality' => 'Indonesia',
            'passenger_type' => 'adult',
            'identity_type' => 'nik',
            'identity_number' => '3201234567890001',
            'passport_expiry' => '2030-12-31',
        ]);

        BookingPassenger::create([
            'id' => Str::uuid(),
            'booking_id' => $booking->id,
            'title' => 'Mr',
            'full_name' => 'Budi Santoso',
            'date_of_birth' => '1998-08-15',
            'nationality' => 'Indonesia',
            'passenger_type' => 'adult',
            'identity_type' => 'passport',
            'identity_number' => 'A12345678',
            'passport_expiry' => '2031-05-20',
        ]);

        BookingPassenger::create([
            'id' => Str::uuid(),
            'booking_id' => $booking->id,
            'title' => 'Mrs',
            'full_name' => 'Siti Aminah',
            'date_of_birth' => '2003-02-01',
            'nationality' => 'Indonesia',
            'passenger_type' => 'adult',
            'identity_type' => 'nik',
            'identity_number' => '3201234567890002',
            'passport_expiry' => '2032-08-15',
        ]);
    }
}
