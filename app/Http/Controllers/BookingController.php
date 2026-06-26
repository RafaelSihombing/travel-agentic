<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Inertia\Response;

class BookingController extends Controller
{
    public function index(): Response
    {
        $bookings = Booking::query()
            ->with([
                'flight.airline',
                'flight.departureAirport',
                'flight.arrivalAirport',
                'recommendations',
            ])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return inertia('LandingPage/Booking/Index', [
            'bookings' => BookingResource::collection($bookings)
                ->additional([
                    'meta' => [
                        'has_pages' => $bookings->hasPages(),
                    ],
                ]),
        ]);
    }

    public function show(Booking $booking): Response
    {
        $booking->load([
            'flight.airline',
            'flight.departureAirport',
            'flight.arrivalAirport',
            'flight.flightStatus',
            'flight.alternativeFlights.alternativeFlight.airline',
            'flight.alternativeFlights.alternativeFlight.departureAirport',
            'flight.alternativeFlights.alternativeFlight.arrivalAirport',
            'flight.alternativeFlights.alternativeFlight.flightStatus',
            'recommendations',
            'agentLogs',
            'passengers',
        ]);

        $booking->load([
            'recommendations' => function ($query) {
                $query->latest()->limit(1);
            }
        ]);
        return inertia('LandingPage/Booking/Detail', [
            'booking' => $booking,
        ]);
    }
}
