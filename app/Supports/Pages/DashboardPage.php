<?php

namespace App\Supports\Pages;

class DashboardPage
{
    public static function index(): array
    {
        return [
            'title' => 'Dashboard',
            'subtitle' => 'Pantau aktivitas penerbangan, pemesanan, dan rekomendasi AI secara real-time.',
            'banner' => [
                'title' => 'Selamat Datang di FlightHub Admin',
                'subtitle' => 'Kelola data penerbangan, booking, serta pantau aktivitas AI Agent untuk memastikan pengalaman perjalanan yang optimal.',
            ],
        ];
    }

    public static function breadcrumbs(): array
    {
        return [
            [
                'label' => 'Dashboard',
                'href' => route('dashboard'),
            ],
            [
                'label' => 'Dashboard',
            ],
        ];
    }
}
