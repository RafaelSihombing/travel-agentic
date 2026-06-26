<?php

namespace Database\Seeders;

use App\Models\AlternativeFlight;
use App\Models\Flight;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AlternativeFlightsSeeder extends Seeder
{
    public function run(): void
    {
        $flights = Flight::query()->orderBy('flight_number')->get();
        if ($flights->count() < 5) {
            return;
        }
        $alternatives = [
            [
                'original_flight_id' => $flights[0]->id,
                'alternative_flight_id' => $flights[1]->id,
                'reason' => 'Alternatif penerbangan dengan rute serupa.',
            ],
            [
                'original_flight_id' => $flights[1]->id,
                'alternative_flight_id' => $flights[2]->id,
                'reason' => 'Maskapai partner tersedia'
            ],

            [
                'original_flight_id' => $flights[2]->id,
                'alternative_flight_id' => $flights[3]->id,
                'reason' => 'Jadwal keberangkatan paling dekat.',
            ],
            [
                'original_flight_id' => $flights[3]->id,
                'alternative_flight_id' => $flights[4]->id,
                'reason' => 'Penerbangan pengganti tersedia.',
            ],
        ];

        foreach ($alternatives as $alternative) {
            AlternativeFlight::create([
                'id' => Str::uuid(),
                'original_flight_id' => $alternative['original_flight_id'],
                'alternative_flight_id' => $alternative['alternative_flight_id'],
                'reason' => $alternative['reason'],
            ]);
        }
    }
}
