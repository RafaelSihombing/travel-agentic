<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Traits\HasFilter;
use App\Traits\HasSorting;

class AgentLog extends Model
{
    use HasUuids, HasFilter, HasSorting;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'flight_id',
        'booking_id',
        'trigger_event',
        'delay_minutes',
        'severity',
        'recommendation_type',
        'message',
    ];

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
