<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    /**
     * At the moment this method will simply output the date.
     * When we'll have the time, we'll display the date according to the user
     * preference.
     */
    public static function parse(Carbon $date): string
    {
        return $date->format('d/m/Y H:i');
    }
}
