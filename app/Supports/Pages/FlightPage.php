<?php

namespace App\Supports\Pages;

class FlightPage
{
    public static function index(): array
    {
        return [
            'title' => 'Data Penerbangan',
            'subtitle' => 'Kelola daftar Penerbangan untuk kebutuhan penerbangan',
            'banner' => [
                'title' => 'Master Penerbangan',
                'subtitle' => 'Data penerbangan digunakan untuk mengatur informasi penerbangan.',
            ],
        ];
    }

    public static function create(): array
    {
        return [
            'title' => 'Tambah Penerbangan',
            'subtitle' => 'Tambahkan data Penerbangan baru ke sistem.',
            'method' => 'POST',
            'action' => route('flights.store'),
        ];
    }

    public static function edit($flight): array
    {
        return [
            'title' => 'Perbarui Penerbangan',
            'subtitle' => 'Perbarui informasi Penerbangan yang sudah terdaftar.',
            'method' => 'PUT',
            'action' => route('flights.update', $flight),
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
                'label' => 'Penerbangan',
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
                'label' => 'Penerbangan',
                'href' => route('flights.index'),
            ],
            [
                'label' => 'Tambah Penerbangan',
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
                'label' => 'Penerbangan',
                'href' => route('flights.index'),
            ],
            [
                'label' => 'Perbarui Penerbangan',
            ],
        ];
    }
}
