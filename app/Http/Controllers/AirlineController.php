<?php

namespace App\Http\Controllers;

use App\Enums\MessageType;
use App\Http\Controllers\Controller;
use App\Http\Requests\AirlineRequest;
use App\Http\Resources\AirlineResource;
use App\Models\Airline;
use App\Supports\Pages\AirlinePage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;
use Inertia\Response;
use Throwable;

class AirlineController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $airlines = Airline::query()
            ->select([
                'id',
                'code',
                'name',
                'logo',
                'created_at',
            ])
            ->filter(request()->only(['search']))
            ->sorting(request()->only([
                'field',
                'direction',
            ]))
            ->paginate(request()->load ?? 10)
            ->withQueryString();

        return inertia('Airline/Index', [
            'pageSettings' => fn() => AirlinePage::index(),

            'items' => fn() => AirlinePage::breadcrumbs(),

            'airlines' => fn() =>
            AirlineResource::collection($airlines)
                ->additional([
                    'meta' => [
                        'has_pages' => $airlines->hasPages(),
                    ],
                ]),

            'state' => fn() => [
                'page' => request()->page ?? 1,
                'search' => request()->search ?? '',
                'load' => request()->load ?? 10,
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return inertia('Airline/Create', [
            'pageSettings' => fn() => AirlinePage::create(),
            'items' => fn() => AirlinePage::createBreadcrumbs(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AirlineRequest $request): RedirectResponse
    {
        try {

            $logo = null;
            if ($request->hasFile('logo')) {

                $logo = $request
                    ->file('logo')
                    ->store('airlines', 'public');
            }

            Airline::create([
                'code' => strtoupper($request->code),
                'name' => $request->name,
                'logo' => $logo,
            ]);

            flashMessage(MessageType::CREATED->message('Maskapai'));
            return to_route('airlines.index');
        } catch (Throwable $e) {
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('airlines.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Airline $airline)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Airline $airline): Response
    {
        // dd($airline->toArray());
        return inertia('Airline/Edit', [
            'pageSettings' => fn() => AirlinePage::edit($airline),
            'airline' => fn() => new AirlineResource($airline),
            'items' => fn() => AirlinePage::editBreadcrumbs(),
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(AirlineRequest $request, Airline $airline): RedirectResponse
    {

        try {

            $logo = $airline->logo;

            if ($request->hasFile('logo')) {

                if (
                    $airline->logo &&
                    Storage::disk('public')
                    ->exists($airline->logo)
                ) {
                    Storage::disk('public')
                        ->delete($airline->logo);
                }

                $logo = $request
                    ->file('logo')
                    ->store('airlines', 'public');
            }

            $airline->update([
                'code' => strtoupper($request->code),
                'name' => $request->name,
                'country' => $request->country,
                'logo' => $logo,
            ]);

            flashMessage(
                MessageType::UPDATED->message('Maskapai')
            );

            return to_route('airlines.index');
        } catch (Throwable $e) {

            flashMessage(
                MessageType::ERROR->message(
                    error: $e->getMessage()
                ),
                'error'
            );

            return to_route('airlines.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Airline $airline)
    {
        try {
            $airline->delete();
            flashMessage(MessageType::DELETE->message('Bandara'));
            return to_route('airlines.index');
        } catch (Throwable $e) {
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('airlines.index');
        }
    }
}
