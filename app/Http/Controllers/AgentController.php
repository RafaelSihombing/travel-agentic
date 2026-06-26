<?php

namespace App\Http\Controllers;

use App\Http\Resources\AgentLogResource;
use App\Http\Resources\AgentRecommendationResource;
use App\Models\AgentLog;
use App\Models\AgentRecommendation;
use App\Supports\Pages\AgentPage;
use Illuminate\Http\Request;
use Inertia\Response;

class AgentController extends Controller
{
    public function agentLogs(): Response
    {
        $flights = AgentLog::query()
            ->with([
                'flight',
                'booking',

            ])
            ->filter(request()->only([
                'search',
            ]))
            ->sorting(request()->only([
                'field',
                'direction',
            ]))
            ->paginate(request()->load ?? 10)
            ->withQueryString();

        return inertia('AgentLog/Index', [
            'pageSettings' => fn() => AgentPage::agentLogs(),

            'items' => fn() => AgentPage::breadcrumbsAgentLogs(),

            'agentLogs' => fn() =>
            AgentLogResource::collection($flights)
                ->additional([
                    'meta' => [
                        'has_pages' => $flights->hasPages(),
                    ],
                ]),

            'state' => fn() => [
                'page' => request()->page ?? 1,
                'search' => request()->search ?? '',
                'load' => request()->load ?? 10,
            ],
        ]);
    }

    public function agentRecommendations(): Response
    {
        $flights = AgentRecommendation::query()
            ->with([
                'flight',
                'booking',

            ])
            ->filter(request()->only([
                'search',
            ]))
            ->sorting(request()->only([
                'field',
                'direction',
            ]))
            ->paginate(request()->load ?? 10)
            ->withQueryString();

        return inertia('AgentRecommendation/Index', [
            'pageSettings' => fn() => AgentPage::agentRecommendation(),

            'items' => fn() => AgentPage::breadcrumbsAgentRecommendation(),

            'recommendations' => fn() =>
            AgentRecommendationResource::collection($flights)
                ->additional([
                    'meta' => [
                        'has_pages' => $flights->hasPages(),
                    ],
                ]),

            'state' => fn() => [
                'page' => request()->page ?? 1,
                'search' => request()->search ?? '',
                'load' => request()->load ?? 10,
            ],
        ]);
    }
}
