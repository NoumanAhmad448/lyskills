<?php

namespace App\Traits;

use Eren\Lms\Classes\LmsCarbon;

trait SetTime
{
    public function setTime($time)
    {
        if (is_null($time)) {
            $this->default_time = LmsCarbon::now()->addDay();
        } else {
            $this->default_time = $time;
        }
    }
}
