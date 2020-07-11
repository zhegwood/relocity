<?php

namespace App\Services\Calendar;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class CalendarService
{

    protected static $busy_hours = [8, 9, 12, 14, 16];
    /**
     * Returns a collection of Calendar Busy times.
     *
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return array
     */
    public static function getCalendarBusyTimes(Carbon $startDate, Carbon $endDate)
    {
        $timezone = CalendarService::getCalendarTimezone();
        $period = CarbonPeriod::since($startDate->startOfHour()->tz($timezone))->hours(1)->until($endDate->tz($timezone));

        $dates = [];

        foreach ($period as $date) {

            $isBusy = array_search($date->hour, self::$busy_hours);

            if ($isBusy > -1) {
                $dates[] = [
                    'start_date' => $date,
                    'end_date' => $date->copy()->addHour(),
                ];
            }
        }

        return $dates;
    }

    /**
     * Returns a collection of Calendar Free times between 8AM and 8PM LA Time.
     *
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @param optional $timezone
     * @return array
     */
    public static function getCalendarFreeTimes(Carbon $startDate, Carbon $endDate)
    {
        $timezone = CalendarService::getCalendarTimezone();
        $start = $startDate->tz($timezone)->startOfDay()->setHours(8);
        $end = $endDate->tz($timezone)->startOfDay()->setHours(19);
        $period = CarbonPeriod::since($start)->hours(1)->until($end);
        foreach ($period as $date) {
            if (in_array($date->hour, self::$busy_hours)) {
                continue;
            }
            $dates[] = [
                'start_date' => $date,
                'end_date' => $date->copy()->addHour(),
            ];
        }
        return $dates;
    }

    /**
     * Returns the Calendar Timezone setting.
     *
     * @return String
     */
    public static function getCalendarTimezone()
    {
        return 'America/Los_Angeles';
    }
}
