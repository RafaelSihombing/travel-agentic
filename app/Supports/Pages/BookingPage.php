<?php

namespace App\Supports\Pages;

class BookingPage
{
    public static function index(): array
    {
        return [
            'title' => 'Data Booking',
            'subtitle' => 'Kelola seluruh data pemesanan tiket penerbangan.',

            'banner' => [
                'title' => 'Booking Penerbangan',
                'subtitle' => 'Pantau dan kelola seluruh transaksi pemesanan tiket pesawat.',
            ],
        ];
    }

    public static function create(): array
    {
        return [
            'title' => 'Tambah Booking',
            'subtitle' => 'Tambahkan data booking penerbangan baru.',
            'method' => 'POST',
            'action' => route('bookings.store'),
        ];
    }

    public static function edit($booking): array
    {
        return [
            'title' => 'Perbarui Booking',
            'subtitle' => 'Perbarui informasi booking penerbangan.',
            'method' => 'PUT',
            'action' => route('bookings.update', $booking),
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
                'label' => 'Booking',
                'href' => route('bookings.index'),
            ],
            [
                'label' => 'Perbarui Booking',
            ],
        ];
    }

    public static function breadcrumbs(?string $current = null): array
    {
        $items = [
            [
                'label' => 'Dashboard',
                'href' => route('dashboard'),
            ],
            [
                'label' => 'Booking',
                'href' => route('bookings.index'),
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
