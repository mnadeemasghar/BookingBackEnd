<?php

namespace App\Helpers;

use App\Models\ActiveDriver;
use App\Models\Booking;
use App\Models\UserLog;
use Carbon\Carbon;
use Illuminate\Database\Console\Migrations\StatusCommand;
use Illuminate\Support\Facades\Auth;

class Helper
{
    public static function userLogEntry($activity)
    {
        UserLog::create(["user_id" => Auth::user()->id, "activity" => $activity]);
        if($activity == 'login' && Auth::user()->role == 'Driver'){
            ActiveDriver::create(['driver_id' => Auth::user()->id]);
        }
        else if($activity == 'logout' && Auth::user()->role == 'Driver'){
            $getActiveDriver = ActiveDriver::where('driver_id',Auth::user()->id)->first();
            $getActiveDriver->delete();
        }
    }

    public static function unattended_rides(){
        return Booking::wherein('status',["pending"])->whereDate('created_at',"<=",Carbon::now()->addMinutes(15))->with('passengers')->with('driver')->get();
    }
}
