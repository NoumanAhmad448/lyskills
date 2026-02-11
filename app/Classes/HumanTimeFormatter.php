<?php

namespace App\Classes;

use App\Classes\Contracts\TimeFormatterInterface;
use Carbon\CarbonInterval;

class HumanTimeFormatter implements TimeFormatterInterface
{
    public function format(int $totalSeconds): string
    {
        return CarbonInterval::seconds($totalSeconds)
            ->cascade()
            ->forHumans();
    }
}
