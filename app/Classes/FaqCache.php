<?php

namespace App\Classes;

use App\Models\Course;
use App\Models\Faq;
use App\Traits\SetTime;
use App\Classes\LyskillsCarbon;
use Illuminate\Support\Facades\Cache;

class FaqCache
{
    use SetTime;

    private $default_time = 1;
    public const FAQS = "faqs";

    public static function faqs()
    {
        return Faq::where('status', 'published')->select('id', 'title', 'message', 'upload_img', 'f_name', 'slug')->orderByDesc('created_at')->first();
    }

    public static function setFaqs(?LyskillsCarbon $time = null)
    {
        (new static)->setTime($time);
        return Cache::remember(self::FAQS, (new static)->default_time, fn() => self::faqs());
    }
}
