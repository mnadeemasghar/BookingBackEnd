<?php

namespace App\Helpers;

use App\Models\UserLog;
use Illuminate\Support\Facades\Auth;

class Helper
{
    public static function userLogEntry($activity)
    {
        UserLog::create(["user_id" => Auth::user()->id, "activity" => $activity]);
    }
}
