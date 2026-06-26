<?php

namespace App\Models;

use App\Traits\HasFilter;
use App\Traits\HasSorting;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class AlternativeFlight extends Model
{
    use HasUuids, HasFilter, HasSorting;

    protected $fillable = [
        'original_flight_id',
        'alternative_flight_id',
        'reason',
    ];

    protected $searchable = [
        'original_flight_id',
        'alternative_flight_id',
        'reason',
    ];

    public function originalFlight()
    {
        return $this->belongsTo(
            Flight::class,
            'original_flight_id'
        );
    }

    public function alternativeFlight()
    {
        return $this->belongsTo(
            Flight::class,
            'alternative_flight_id'
        );
    }

    public function recommendation()
    {
        return $this->belongsTo(
            AgentRecommendation::class
        );
    }
}
