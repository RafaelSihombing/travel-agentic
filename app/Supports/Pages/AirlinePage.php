<?php

namespace App\Supports\Pages;

class AirlinePage
{
    public static function index(): array
    {
        return [
            'title' => 'Data Maskapai',
            'subtitle' => 'Kelola daftar maskapai untuk kebutuhan penerbangan',
            'banner' => [
                'title' => 'Master Maskapai',
                'subtitle' => 'Data maskapai digunakan untuk mengatur informasi penerbangan.',
            ],
        ];
    }

    public static function create(): array
    {
        return [
            'title' => 'Tambah Maskapai',
            'subtitle' => 'Tambahkan data maskapai baru ke sistem.',
            'method' => 'POST',
            'action' => route('airlines.store'),
        ];
    }

    public static function edit($airline): array
    {
        return [
            'title' => 'Perbarui Maskapai',
            'subtitle' => 'Perbarui informasi maskapai yang sudah terdaftar.',
            'method' => 'PUT',
            'action' => route('airlines.update', $airline),
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
                'label' => 'Maskapai',
            ],
        ];
    }

    public static function createBreadcrumbs(): array
    {
        return [
            [
                'label' => 'Dashboard',
                'href' => route('dashboard'),
            ],
            [
                'label' => 'Maskapai',
                'href' => route('airlines.index'),
            ],
            [
                'label' => 'Tambah Maskapai',
            ],
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
                'label' => 'Maskapai',
                'href' => route('airlines.index'),
            ],
            [
                'label' => 'Perbarui Maskapai',
            ],
        ];
    }
}
