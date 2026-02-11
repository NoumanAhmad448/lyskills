<?php

namespace App\Classes;

use App\Classes\Contracts\TimeFormatterInterface;
use Carbon\CarbonInterval;

class HourMinuteTimeFormatter implements TimeFormatterInterface
{
    public function format(int $totalSeconds): string
    {
        $interval = CarbonInterval::seconds($totalSeconds)->cascade();

        $hours = str_pad((int) $interval->totalHours, 2, '0', STR_PAD_LEFT);
        $minutes = str_pad($interval->minutes, 2, '0', STR_PAD_LEFT);

        return "{$hours}:{$minutes}";
    }
}
