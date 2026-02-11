<?php

namespace App\Http\Response;

use App\Classes\CacheKeys;
use App\Classes\CourseCache;
use App\Classes\FaqCache;
use App\Classes\PostCache;
use App\Classes\ResponseKeys;
use App\Http\Contracts\IndexContracts;
use App\Models\Faq;
use App\Models\RatingModal;
use App\Models\Setting;
use Exception;
use Illuminate\Support\Facades\Cache;

class IndexResponse implements IndexContracts
{
    public function toResponse($request)
    {
        try {

            $settings = Setting::first();
            $RatingModal = RatingModal::class;
            $title = __('messages.site_title');
            $desc = __('description.home');
            $cs =  Cache::has(CacheKeys::CATEGORIES) ? Cache::get(CacheKeys::CATEGORIES) : CacheKeys::setcourseCategories();
            $post = Cache::has(PostCache::FIRST_POST) ? Cache::get(PostCache::FIRST_POST) : PostCache::setFristPost();
            $faq = Cache::has(FaqCache::FAQS) ? Cache::get(FaqCache::FAQS) : FaqCache::setFaqs();
            $courses = Cache::has(CourseCache::COURSES) ? Cache::get(CourseCache::COURSES) : CourseCache::setCourses();

            $data = compact('title', 'desc', 'cs', 'post', 'faq', 'courses', "settings", "RatingModal");
            return $request->wantsJson()
                ? response()->json($data)
                : view(config("setting.welcome_blade"), $data);
        } catch (Exception $e) {
            return server_logs([true, $e], [true, $request]);
        }
    }
}
