<?php

namespace App\Supports\Pages;

class AlternativeFlightPage
{
    public static function index(): array
    {
        return [
            'title' => 'Alternative Flight',
            'subtitle' => 'Daftar penerbangan alternatif yang direkomendasikan AI.',

            'banner' => [
                'title' => 'Alternative Flight',
                'subtitle' => 'Penerbangan alternatif dibuat otomatis ketika terjadi gangguan jadwal.',
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
                'label' => 'Alternative Flight',
            ],
        ];
    }
}
