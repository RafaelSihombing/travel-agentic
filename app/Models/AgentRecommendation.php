<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Traits\HasFilter;
use App\Traits\HasSorting;

class AgentRecommendation extends Model
{
    use HasUuids, HasFilter, HasSorting;
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'booking_id',
        'flight_id',
        'recommendation_type',
        'severity',
        'title',
        'message',
        'suggested_action',
        'is_read',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }
}
