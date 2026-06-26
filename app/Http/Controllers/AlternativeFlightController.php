<?php

namespace App\Http\Controllers;

use App\Http\Resources\AlternativeFlightResource;
use App\Models\AlternativeFlight;
use App\Supports\Pages\AlternativeFlightPage;
use Illuminate\Http\Request;
use Inertia\Response;

class AlternativeFlightController extends Controller
{
    public function index(): Response
    {
        $alternatives = AlternativeFlight::query()
            ->with([
                'recommendation.booking',
                'originalFlight.airline',
                'originalFlight.departureAirport',
                'originalFlight.arrivalAirport',
                'alternativeFlight.airline',
                'alternativeFlight.departureAirport',
                'alternativeFlight.arrivalAirport',
            ])
            ->paginate(request()->load ?? 10)
            ->withQueryString();

        return inertia('AlternativeFlight/Index', [
            'pageSettings' => fn() => AlternativeFlightPage::index(),
            'items' => fn() => AlternativeFlightPage::breadcrumbs(),
            'alternatives' => fn() =>
            AlternativeFlightResource::collection($alternatives)
                ->additional([
                    'meta' => [
                        'has_pages' => $alternatives->hasPages(),
                    ],
                ]),

            'state' => fn() => [
                'page' => request()->page ?? 1,
                'load' => request()->load ?? 10,
            ],
        ]);
    }
}
