<?php
namespace App\Helpers;

use Carbon\Carbon;

class ConfigTime
{
    public static function time()
    {
        $time = new Carbon();
        $time->setTimezone(env('APP_TIMEZONE'));
        $hour = $time->format('H');

        if ($hour >= 5 && $hour < 12) {
            return 'Good Morning'; // 05:00 - 11:59
        } elseif ($hour >= 12 && $hour < 15) {
            return 'Good Afternoon'; // 12:00 - 14:59
        } elseif ($hour >= 15 && $hour < 18) {
            return 'Good Evening'; // 15:00 - 17:59
        } else {
            return 'Good Night'; // 18:00 - 04:59
        }
    }
}
