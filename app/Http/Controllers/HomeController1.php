<?php

namespace App\Http\Controllers;

use App\Http\Contracts\IndexContracts;
use App\Models\Categories;
use App\Models\Course;
use App\Models\Faq;
use App\Models\Post;
use App\Models\Page;
use Exception;
use App\Models\RatingModal;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Routing\Pipeline;

class HomeController1 extends Controller
{
    public function index()
    {
        return app(IndexContracts::class);
    }

    public function post($slug)
    {
        try {
            $title = $slug;
            $post = Post::where('slug', $slug)->first();
            if (!$post) {
                return redirect()->route('index');
            }

            $desc = substr(trim(strip_tags($post->message)), 0, 165);

            $c_img = $post->upload_img;

            $next = Post::where('status', 'published')->find($post->id + 1);
            $prev = Post::where('status', 'published')->find($post->id - 1);
            return view('public_post.view_post', compact('post', 'title', 'next', 'prev', 'desc', 'c_img'));
        } catch (\Throwable $th) {
            return back()->with('error', 'server error');
        }
    }

    public function page($slug)
    {
        try {
            $title = $slug;
            $page = Page::where('slug', $slug)->first();
            if (!$page) {
                return redirect()->route('index');
            }

            $desc = "";
            switch ($slug) {
                case 'privacy-policy':
                    $desc = __('description.privacy');
                    break;
                case 'terms-and-conditions':
                    $desc = __('description.terms');
                    break;
                case 'about-us':
                    $desc = __('description.about_us');
                    break;
            }


            return view('public_post.view_page', compact('page', 'title', 'desc'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function faq($slug)
    {
        try {
            $title = $slug;
            $faq = Faq::where('slug', $slug)->first();
            if (!$faq) {
                return redirect()->route('index');
            }
            $desc = substr(trim(strip_tags($faq->message)), 0, 165);

            $c_img = $faq->upload_img;

            $next = FAQ::where('id', $faq->id + 1)->where('status', 'published')->first();
            $prev = FAQ::where('status', 'published')->find($faq->id - 1);
            return view('public_post.view_faq', compact('faq', 'title', 'next', 'prev', 'desc', 'c_img'));
        } catch (\Throwable $th) {
        }
    }

    public function faqs()
    {
        try {
            $title = 'faq';
            $faqs = FAQ::where('status', 'published')->orderByDesc('created_at')->simplePaginate(15);
            return view('faq', compact('title', 'faqs'));
        } catch (\Throwable $th) {
            return back();
        }
    }
}
