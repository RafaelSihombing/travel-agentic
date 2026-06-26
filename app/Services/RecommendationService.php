<?php

namespace App\Services;


use App\Models\Flight;


class RecommendationService
{
    public function getRecommendations()
    {
        return Flight::query()
            ->with([
                'airline',
                'departureAirport',
                'arrivalAirport',
                'flightStatus'
            ])
            ->whereHas('flightStatus', function ($q) {
                $q->where('status', 'on_time');
            })
            ->orderBy('price')
            ->limit(3)
            ->get();
    }
}
