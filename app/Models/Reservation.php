<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'event_name',
        'venue_name',
        'regular_seats',
        'vip_seats',
        'event_date',
    ];
}
