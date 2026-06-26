<?php

namespace Database\Seeders;

use App\Models\Airline;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AirlinesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Airline::insert([
            [
                'id' => Str::uuid(),
                'code' => 'GA',
                'name' => 'Garuda Indonesia',
                'logo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'code' => 'QG',
                'name' => 'Citilink',
                'logo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'code' => 'ID',
                'name' => 'Batik Air',
                'logo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'code' => 'JT',
                'name' => 'Lion Air',
                'logo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'code' => 'QZ',
                'name' => 'AirAsia Indonesia',
                'logo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
