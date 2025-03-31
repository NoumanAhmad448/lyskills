<?php

namespace App\Classes;

use App\Models\Course;
use App\Traits\SetTime;
use Eren\Lms\Classes\LmsCarbon;
use Illuminate\Support\Facades\Cache;

class CourseCache
{
    use SetTime;

    private $default_time = 86400;
    public const COURSES = "courses";

    public static function courses()
    {
        return Course::where('status', 'published')->whereNull('is_deleted')->with(['price:id,course_id,pricing,is_free', 'user:id,name', 'course_image'])
            ->select('id', 'user_id', 'course_title', 'categories_selection', 'slug')->orderByDesc('created_at')->paginate(20);
    }

    public static function setCourses(?LmsCarbon $time = null)
    {
        (new static)->setTime($time);
        return Cache::remember(self::COURSES, (new static)->default_time, fn() => self::courses());
    }
}
