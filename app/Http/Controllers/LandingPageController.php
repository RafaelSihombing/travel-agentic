<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use App\Models\Airport;
use App\Models\Booking;
use App\Models\BookingPassenger;
use App\Models\Flight;
use App\Services\RecommendationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class LandingPageController extends Controller
{
    public function index(): Response
    {
        $flights = Flight::query()->with([
            'airline',
            'departureAirport',
            'arrivalAirport',
            'flightStatus'
        ])->latest()->take(10)->get();

        $recommendations = app(RecommendationService::class)
            ->getRecommendations();

        $airports = Airport::orderBy('city')
            ->get();

        return inertia('LandingPage/Index', [
            'flights' => $flights,
            'airports' => $airports,
            'recommendations' => $recommendations
        ]);
    }

    public function search(Request $request)
    {
        $flights = Flight::with([
            'airline',
            'departureAirport',
            'arrivalAirport',
            'flightStatus',
        ])
            ->where('departure_airport_id', $request->departure_airport_id)
            ->where('arrival_airport_id', $request->arrival_airport_id)
            ->whereDate('scheduled_departure', $request->scheduled_departure)
            ->get();

        // dd($flights);

        $departureAirport = Airport::find($request->departure_airport_id);

        $arrivalAirport = Airport::find($request->arrival_airport_id);
        $airlines = Airline::orderBy('name')->get();

        return Inertia::render(
            'LandingPage/Flights/SearchResult',
            [
                'flights' => $flights,
                'airlines' => $airlines,
                'search' => [
                    'departure_airport' => $departureAirport,
                    'arrival_airport' => $arrivalAirport,

                    'scheduled_departure' => $request->scheduled_departure,

                    'return_date' => $request->return_date,

                    'passenger_count' => $request->passenger_count,
                    'seat_class' => $request->seat_class,

                    'direct_flight' => $request->boolean('direct_flight'),
                    'ai_recommendation' => $request->boolean('ai_recommendation'),
                ],
            ]
        );
    }
    public function passenger(Request $request, Flight $flight): Response
    {
        $flight->load([
            'airline',
            'departureAirport',
            'arrivalAirport',
            'flightStatus',
        ]);

        return Inertia::render(
            'LandingPage/Flights/PassengerInformation',
            [
                'flight' => $flight,

                'search' => [
                    'departure_airport_id' => $request->departure_airport_id,
                    'arrival_airport_id' => $request->arrival_airport_id,
                    'scheduled_departure' => $request->scheduled_departure,
                    'passenger_count' => (int) $request->passenger_count,
                    'seat_class' => $request->seat_class,
                    'direct_flight' => $request->boolean('direct_flight'),
                    'ai_recommendation' => $request->boolean('ai_recommendation'),
                ],
            ]
        );
    }

    public function review(Request $request): Response
    {
        $validated = $request->validate([
            'flight_id' => ['required', 'exists:flights,id'],

            'contact_name' => ['required', 'string', 'max:255'],
            'contact_email' => ['required', 'email'],
            'contact_phone' => ['required', 'string', 'max:20'],

            'passengers' => ['required', 'array', 'min:1'],

            'passengers.*.full_name' => ['required', 'string', 'max:255'],
            'passengers.*.identity_type' => ['required', 'in:nik,passport'],
            'passengers.*.identity_number' => ['required', 'string', 'max:50'],
        ]);

        $flight = Flight::with([
            'airline',
            'departureAirport',
            'arrivalAirport',
            'flightStatus',
        ])->findOrFail($validated['flight_id']);

        return Inertia::render(
            'LandingPage/Flights/ReviewBooking',
            [
                'flight' => $flight,
                'booking' => $validated,

                'search' => [
                    'passenger_count' => $request->passenger_count,
                    'seat_class' => $request->seat_class,
                    'direct_flight' => $request->boolean('direct_flight'),
                    'ai_recommendation' => $request->boolean('ai_recommendation'),
                    'scheduled_departure' => $request->scheduled_departure,
                ],
            ]
        );
    }

    public function payment(Request $request): Response
    {
        $validated = $request->validate([
            'flight_id' => ['required', 'exists:flights,id'],

            'contact_name' => ['required', 'string', 'max:255'],
            'contact_email' => ['required', 'email'],
            'contact_phone' => ['required', 'string', 'max:20'],

            'passenger_count' => ['required', 'integer'],
            'seat_class' => ['required', 'string'],

            'passengers' => ['required', 'array', 'min:1'],
            'passengers.*.full_name' => ['required', 'string', 'max:255'],
            'passengers.*.identity_type' => ['required', 'in:nik,passport'],
            'passengers.*.identity_number' => ['required', 'string', 'max:50'],
        ]);

        $flight = Flight::with([
            'airline',
            'departureAirport',
            'arrivalAirport',
            'flightStatus',
        ])->findOrFail($validated['flight_id']);

        $totalPrice = $flight->price * $validated['passenger_count'];

        $booking = DB::transaction(function () use (
            $validated,
            $flight,
            $totalPrice
        ) {

            $booking = Booking::create([
                'user_id' => auth()->id(),

                'flight_id' => $flight->id,

                'booking_code' => 'BK' . now()->format('YmdHis'),

                'contact_name' => $validated['contact_name'],
                'contact_email' => $validated['contact_email'],
                'contact_phone' => $validated['contact_phone'],

                'passenger_count' => $validated['passenger_count'],
                'seat_class' => $validated['seat_class'],

                'total_price' => $totalPrice,

                'booking_status' => 'booked',
                'payment_status' => 'unpaid',
            ]);

            foreach ($validated['passengers'] as $passenger) {

                BookingPassenger::create([
                    'booking_id' => $booking->id,

                    'title' => null,
                    'full_name' => $passenger['full_name'],

                    'date_of_birth' => null,
                    'nationality' => 'Indonesia',

                    'passenger_type' => 'adult',

                    'identity_type' => $passenger['identity_type'],
                    'identity_number' => $passenger['identity_number'],

                    'passport_expiry' => null,
                ]);
            }

            return $booking;
        });

        $booking->load([
            'flight.airline',
            'flight.departureAirport',
            'flight.arrivalAirport',
            'flight.flightStatus',
            'passengers',
        ]);

        return Inertia::render(
            'LandingPage/Flights/Payment',
            [
                'booking' => $booking,
            ]
        );
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'booking_id' => ['required', 'exists:bookings,id'],
        ]);

        $booking = Booking::findOrFail($request->booking_id);

        $booking->update([
            'payment_status' => 'paid',
            'booking_status' => 'booked',
        ]);

        return redirect()->route('flights.success', $booking);
    }


    public function success(Booking $booking)
    {
        $booking->load([
            'flight.airline',
            'flight.departureAirport',
            'flight.arrivalAirport',
            'passengers',
        ]);

        return Inertia::render(
            'LandingPage/Flights/Success',
            [
                'booking' => $booking,
            ]
        );
    }
}
