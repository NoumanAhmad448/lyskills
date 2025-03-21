<?php

namespace App\Http\Response;

use App\Http\Contracts\IndexContracts;
use App\Models\Categories;
use App\Models\Course;
use App\Models\Faq;
use App\Models\Post;
use App\Models\RatingModal;
use App\Models\Setting;
use Exception;

class IndexResponse implements IndexContracts
{
    public function toResponse($request)
    {
        try {

            $settings = Setting::first();
            $RatingModal = RatingModal::class;
            $title = __('lms::messages.site_title');
            $desc = __('description.home');
            $cs = Categories::select('id', 'name', 'value')->paginate(20);
            $post = Post::where('status', 'published')->select('id', 'title', 'message', 'upload_img', 'f_name', 'slug')->orderByDesc('created_at')->first();
            $faq = Faq::where('status', 'published')->select('id', 'title', 'message', 'upload_img', 'f_name', 'slug')->orderByDesc('created_at')->first();
            $courses = Course::where('status', 'published')->whereNull('is_deleted')->with(['price:id,course_id,pricing,is_free', 'user:id,name', 'course_image'])
                ->select('id', 'user_id', 'course_title', 'categories_selection', 'slug')->orderByDesc('created_at')->paginate(20);

            return $request->wantsJson()
                ? response()->json([
                    'title' => $title,
                    'desc' => $desc,
                    'cs' => $cs,
                    'post' => $post,
                    'faq' => $faq,
                    'courses' => $courses,
                    "settings" => $settings,
                    "RatingModal" => $RatingModal
                ])
                : view(config("setting.welcome_blade"), compact('title', 'desc', 'cs', 'post', 'faq', 'courses', "settings", "RatingModal"));
        } catch (Exception $e) {
            debug_logs($e->getMessage());
            return back()->with('error', __("messages.universal_err_msg"));
        }
    }
}
