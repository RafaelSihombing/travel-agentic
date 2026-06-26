<?php

namespace App\Console\Commands;

use App\Models\Flight;
use App\Models\FlightStatus;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

#[Signature('app:simulate-flight-status-command')]
#[Description('Command description')]
class SimulateFlightStatusCommand extends Command
{
    protected $signature = 'flight:simulate';

    protected $description = 'Simulate flight status updates';

    public function handle()
    {
        $flight = Flight::inRandomOrder()->first();

        if (!$flight) {
            $this->error('No flight found');
            return Command::FAILURE;
        }

        $statuses = [
            [
                'status' => 'on_time',
                'delay_minutes' => 0,
                'reason' => null,
            ],
            [
                'status' => 'delayed',
                'delay_minutes' => 45,
                'reason' => 'Weather Conditions',
            ],
            [
                'status' => 'delayed',
                'delay_minutes' => 120,
                'reason' => 'Technical Issue',
            ],
            [
                'status' => 'delayed',
                'delay_minutes' => 300,
                'reason' => 'Airport Congestion',
            ],
        ];

        $data = collect($statuses)->random();

        FlightStatus::create([
            'id' => Str::uuid(),
            'flight_id' => $flight->id,
            'status' => $data['status'],
            'delay_minutes' => $data['delay_minutes'],
            'reason' => $data['reason'],
        ]);

        $this->info(
            "{$flight->flight_number} => {$data['status']} ({$data['delay_minutes']} minutes)"
        );

        return Command::SUCCESS;
    }
}
