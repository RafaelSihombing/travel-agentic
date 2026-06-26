<?php

namespace App\Models;

use App\Traits\HasFilter;
use App\Traits\HasSorting;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Booking extends Model
{
    use HasUuids, HasFilter, HasSorting;
    protected $table = 'bookings';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['user_id', 'flight_id', 'booking_code', 'contact_name', 'contact_email', 'contact_phone', 'passenger_count', 'passenger_count', 'seat_class', 'total_price', 'booking_status', 'payment_status'];
    protected array $searchable = [
        'booking_code',
        'contact_name',
        'contact_email',
        'contact_phone',
    ];

    public function recommendations()
    {
        return $this->hasMany(
            AgentRecommendation::class
        )->latest();
    }

    public function agentLogs()
    {
        return $this->hasMany(
            AgentLog::class
        );
    }

    public function flight()
    {
        return $this->belongsTo(
            Flight::class
        );
    }

    public function passengers()
    {
        return $this->hasMany(
            BookingPassenger::class,
            'booking_id'
        );
    }



    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
