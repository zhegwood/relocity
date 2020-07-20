<?php

namespace App\Http\Controllers;

use App\Services\Calendar\CalendarService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BookingController extends Controller
{
    public function busy(Request $request)
    {
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->endOfDay();
        $busyTimes = CalendarService::getCalendarBusyTimes($startDate, $endDate);
        return $busyTimes;
    }

    public function free(Request $request)
    {
        $startDate = Carbon::now();
        $endDate = Carbon::now();
        $freeTimes = CalendarService::getCalendarFreeTimes($startDate, $endDate);
        return $freeTimes;
    }
}
