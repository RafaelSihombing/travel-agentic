<?php

namespace App\Models;

use App\Traits\HasFilter;
use App\Traits\HasSorting;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class BookingPassenger extends Model
{
    use HasUuids, HasSorting, HasFilter;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'booking_id',
        'title',
        'full_name',
        'date_of_birth',
        'nationality',
        'passenger_type',
        'identity_type',
        'identity_number',
        'passport_expiry',
    ];
}
