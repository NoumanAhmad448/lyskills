<?php

namespace App\Classes;

use Illuminate\Support\Str;

class LyskillsStr
{
    public function __construct() {
        $this->str = Str::class;
    }

    public static function limit($str, $limit=255){
        return $this->str::limit($str,$limit);
    }
}