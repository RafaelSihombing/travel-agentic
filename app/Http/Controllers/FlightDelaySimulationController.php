<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\FlightStatus;
use App\Services\FlightDelayAgentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FlightDelaySimulationController extends Controller
{
    public function simulate(Request $request, Flight $flight, FlightDelayAgentService $agent): RedirectResponse
    {
        $delayMinutes = $request->delay_minutes ?? 180;

        FlightStatus::where('flight_id', $flight->id)->latest()->first()?->update([
            'status' => 'delayed',
            'delay_minutes' => $delayMinutes,
            'reason' => 'Simulasi cuaca buruk',
        ]);

        $agent->handle($flight);

        return back()->with('success', 'Simulasi delay berhasil dan agent sudah membuat rekomendasi.');
    }
}
