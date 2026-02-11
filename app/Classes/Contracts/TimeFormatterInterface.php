<?php

namespace App\Classes\Contracts;

interface TimeFormatterInterface
{
    /**
     * Format total time (in seconds)
     */
    public function format(int $totalSeconds): string;
}
