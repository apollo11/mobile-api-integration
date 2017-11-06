<?php
namespace App\Http\Traits;

use Carbon\Carbon;

trait DateFormatDate
{
    public function convertToUtc($date)
    {
        $tz = date_default_timezone_get();
        $to = Carbon::parse($date, 'Asia/Singapore');
        $from = $to->setTimezone($tz);

        return $from;

    }

}