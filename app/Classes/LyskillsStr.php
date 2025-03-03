<?php

namespace App\Classes;

use Illuminate\Support\Str;

class LyskillsStr
{
    private static $str = Str::class;
    public function __construct() {
    }

    public static function limit($str, $limit=255){
        return Str::limit($str,$limit);
    }
}