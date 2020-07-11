<?php

namespace App\Http\Controllers;

use App\Services\Calendar\CalendarService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BookingController extends Controller
{
    public function busy(Request $reuqest)
    {
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->endOfDay();
        $busyTimes = CalendarService::getCalendarBusyTimes($startDate, $endDate);
        return $busyTimes;
    }

    public function free(Request $reuqest)
    {
        $timeZone = 'America/New_York';
        $startDate = Carbon::now()->setTimezone($timeZone);
        $endDate = Carbon::now()->setTimezone($timeZone);
        $freeTimes = CalendarService::getCalendarFreeTimes($startDate, $endDate);
        return $freeTimes;
    }
}
