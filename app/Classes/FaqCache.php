<?php

namespace App\Classes;

use App\Models\Course;
use App\Models\Faq;
use App\Traits\SetTime;
use Eren\Lms\Classes\LmsCarbon;
use Illuminate\Support\Facades\Cache;

class FaqCache
{
    use SetTime;

    private $default_time = 86400;
    public const FAQS = "faqs";

    public static function faqs()
    {
        return Faq::where('status', 'published')->select('id', 'title', 'message', 'upload_img', 'f_name', 'slug')->orderByDesc('created_at')->first();
    }

    public static function setFaqs(?LmsCarbon $time = null)
    {
        (new static)->setTime($time);
        return Cache::remember(self::FAQS, (new static)->default_time, fn() => self::faqs());
    }
}
