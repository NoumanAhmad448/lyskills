<?php

namespace App\Classes;

use App\Models\Categories;
use App\Traits\SetTime;
use Eren\Lms\Classes\LmsCarbon;
use Illuminate\Support\Facades\Cache;

class CacheKeys
{
    use SetTime;

    private $default_time = 86400;
    public const CATEGORIES = "categories";

    public static function courseCategories()
    {
        return Categories::select('id', 'name', 'value')->paginate(20);
    }

    public static function setcourseCategories(?LmsCarbon $time = null)
    {
        (new static)->setTime($time);
        return Cache::remember(self::CATEGORIES, (new static)->default_time, fn() => self::courseCategories());
    }
}
