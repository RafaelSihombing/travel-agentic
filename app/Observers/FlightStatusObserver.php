<?php

namespace App\Observers;

use App\Models\FlightStatus;
use App\Services\FlightDelayAgentService;

class FlightStatusObserver
{
    /**
     * Handle the FlightStatus "created" event.
     */
    public function created(FlightStatus $flightStatus): void
    {
        if ($flightStatus->status !== 'delayed') {
            return;
        }

        app(FlightDelayAgentService::class)
            ->handle($flightStatus->flight);
    }

    // public function created(FlightStatus $flightStatus): void
    // {
    //     app(FlightDelayAgentService::class)->handle($flightStatus);
    // }

    /**
     * Handle the FlightStatus "updated" event.
     */
    public function updated(FlightStatus $flightStatus): void
    {
        //
    }

    /**
     * Handle the FlightStatus "deleted" event.
     */
    public function deleted(FlightStatus $flightStatus): void
    {
        //
    }

    /**
     * Handle the FlightStatus "restored" event.
     */
    public function restored(FlightStatus $flightStatus): void
    {
        //
    }

    /**
     * Handle the FlightStatus "force deleted" event.
     */
    public function forceDeleted(FlightStatus $flightStatus): void
    {
        //
    }
}
