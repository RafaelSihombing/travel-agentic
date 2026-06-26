<?php

namespace App\Supports\Pages;

class AirportPage
{
    public static function index(): array
    {
        return [
            'title' => 'Data Bandara',
            'subtitle' => 'Kelola daftar bandara untuk kebutuhan penerbangan',

            'banner' => [
                'title' => 'Master Bandara',
                'subtitle' => 'Data bandara digunakan sebagai titik keberangkatan dan tujuan penerbangan.',
            ],
        ];
    }

    public static function create(): array
    {
        return [
            'title' => 'Tambah Bandara',
            'subtitle' => 'Tambahkan data bandara baru ke sistem.',
            'method' => 'POST',
            'action' => route('airports.store'),
        ];
    }

    public static function edit($airport): array
    {
        return [
            'title' => 'Perbarui Bandara',
            'subtitle' => 'Perbarui informasi bandara yang sudah terdaftar.',
            'method' => 'PUT',
            'action' => route('airports.update', $airport),
        ];
    }

    public static function editBreadcrumbs(): array
    {
        return [
            [
                'label' => 'Dashboard',
                'href' => route('dashboard'),
            ],
            [
                'label' => 'Bandara',
                'href' => route('airports.index'),
            ],
            [
                'label' => 'Perbarui Bandara',
            ],
        ];
    }

    public static function breadcrumbs(
        ?string $current = null
    ): array {

        $items = [
            [
                'label' => 'Dashboard',
                'href' => route('dashboard'),
            ],

            [
                'label' => 'Bandara',
                'href' => route('airports.index'),
            ],
        ];

        if ($current) {

            $items[] = [
                'label' => $current,
            ];
        } else {

            unset($items[1]['href']);
        }

        return $items;
    }
}
