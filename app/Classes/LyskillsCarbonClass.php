<?php

namespace App\Classes;

use Carbon\Carbon;

class LyskillsCarbonClass
{
    /**
     * Calculate the difference between two dates in days.
     *
     * @param string $date1
     * @param string $date2
     * @return int
     */
    public static function diffInDays($date1, $date2)
    {
        $date1 = Carbon::parse($date1);
        $date2 = Carbon::parse($date2);

        return $date1->diffInDays($date2);
    }

    /**
     * Calculate the difference between two dates in hours.
     *
     * @param string $date1
     * @param string $date2
     * @return int
     */
    public static function diffInHours($date1, $date2)
    {
        $date1 = Carbon::parse($date1);
        $date2 = Carbon::parse($date2);

        return $date1->diffInHours($date2);
    }

    /**
     * Calculate the difference between two dates in minutes.
     *
     * @param string $date1
     * @param string $date2
     * @return int
     */
    public static function diffInMinutes($date1, $date2)
    {
        $date1 = Carbon::parse($date1);
        $date2 = Carbon::parse($date2);

        return $date1->diffInMinutes($date2);
    }

    /**
     * Get a human-readable difference between two dates.
     *
     * @param string $date1
     * @param string $date2
     * @return string
     */
    public static function diffForHumans($date1, $date2)
    {
        $date1 = Carbon::parse($date1);
        $date2 = Carbon::parse($date2);

        return $date1->diffForHumans($date2);
    }
}