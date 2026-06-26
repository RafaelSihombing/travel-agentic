<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Traits\HasFilter;
use App\Traits\HasSorting;
use Illuminate\Database\Eloquent\Model;
use function Laravel\Prompts\table;

class Airline extends Model
{
    use HasUuids, HasFilter, HasSorting;
    public $incrementing = false;
    protected $fillable = ['name', 'code', 'logo'];
    protected array $searchable  = ['name', 'code'];
}
