<?php

namespace App\Traits;

use App\Classes\LyskillsCarbon;

trait SetTime
{
    public function setTime($time)
    {
        if (is_null($time)) {
            $this->default_time = LyskillsCarbon::now()->addDay();
        } else {
            $this->default_time = $time;
        }
    }
}
