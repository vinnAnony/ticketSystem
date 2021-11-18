<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_name',
        'venue_name',
        'max_attendees',
        'regular_price',
        'vip_price',
        'event_date',
        'remaining_tickets',
    ];
}
