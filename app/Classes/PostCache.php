<?php

namespace App\Classes;

use App\Models\Post;
use App\Traits\SetTime;
use App\Classes\LyskillsCarbon;
use Illuminate\Support\Facades\Cache;

class PostCache
{
    use SetTime;

    private $default_time = 1;
    public const FIRST_POST = "first_post";

    public static function firstPost()
    {
        return Post::where('status', 'published')->select('id', 'title', 'message', 'upload_img', 'f_name', 'slug')->orderByDesc('created_at')->first();
    }

    public static function setFristPost(?LyskillsCarbon $time = null)
    {
        (new static)->setTime($time);
        return Cache::remember(self::FIRST_POST, (new static)->default_time, fn() => self::firstPost());
    }
}
