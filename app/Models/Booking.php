<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'destination',
        'location',
        'pick_date_time',
        'vehicle_type',
        'extras',
        'partner_id',
        'price',
        'reason',
        'not_shown_img',
        'price_driver',
        'passenger_nos',
        'currency'
    ];

    public function passengers()
    {
        return $this->hasMany(Passenager::class);
    }

    public function driver()
    {
        return $this->hasMany(User::class,'id','driver_id');
    }
}
