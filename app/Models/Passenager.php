<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Passenager extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'booking_id',
        'name',
        'phone_number',
        'suitcase_number',
        'flight_date_time',
        'flight_number',
        'flight_airline',
        'flight_arriving_from'
    ];
}
