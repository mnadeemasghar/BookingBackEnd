<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noshow extends Model
{
    use HasFactory;
    protected $fillable = [
        'not_shown_img',
        'lat',
        'lon',
        'booking_id'
    ];
}
