<?php

namespace App\Http\Controllers;

use App\Classes\ResponseKeys;
use App\Http\Contracts\FaqContract;
use App\Http\Contracts\PostsContract;
use App\Http\Requests\ContactUsRequest;
use App\Mail\ContactUsMail;
use App\Models\Categories;
use App\Models\Course;
use App\Models\Faq;
use App\Models\Post;
use App\Models\Page;
use App\Models\R;
use App\Models\u;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\Article;
use App\Models\RatingModal;
use App\Models\Setting;


class HomeController extends Controller
{

    public function faqs()
    {
        return app(FaqContract::class);
    }

    public function logout(Request $request)
    {
        try {
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect('/')->with(ResponseKeys::STATUS, 'you are logged out');
        } catch (\Throwable $e) {
            return server_logs([true, $e], [false], true);
        }
    }

    public function posts()
    {
        return app(PostsContract::class);
    }

    public function contactUs()
    {
        try {
            $title = "contact us";
            $desc = __('description.contact_us');

            return view('xuesheng.contact-us', compact(ResponseKeys::TITLE, 'desc'));
        } catch (\Throwable $e) {
            return server_logs([true, $e], [false], true);
        }
    }

    public function contactUsPost(ContactUsRequest $request)
    {
        try {

            $request->validated();
            Mail::to(config("mail.contact_us_email"))->queue(new ContactUsMail(
                $request->name,
                $request->email,
                $request->mobile ?? '',
                $request->country ?? '',
                $request->subject,
                $request->body
            ));

            return back()->with(ResponseKeys::TITLE, 'Your Message has delivered. We will contact you soon');
        } catch (\Exception $e) {
            return back()->with('error', 'your message was not delievered. Please try again');
        }
    }

    public function upload(Request $request)
    {
        try {
            if ($request->hasFile('upload')) {
                $originName = $request->file('upload')->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->file('upload')->getClientOriginalExtension();
                $fileName = $fileName . '_' . time() . '.' . $extension;

                $request->file('upload')->move(public_path('images'), $fileName);

                $CKEditorFuncNum = $request->input('CKEditorFuncNum');
                $url = asset('images/' . $fileName);
                $msg = 'Image uploaded successfully';
                $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

                @header('Content-type: text/html; charset=utf-8');
                echo $response;
            }
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function getSearch(Request $request)
    {

        try {
            $q = $request->q;
            $ex = '%' . $q . '%';
            $res = Course::
                 where(ResponseKeys::STATUS, Course::PUBLISHED_STATUS)
                ->where('is_deleted',0)
                ->where(function ($query) use ($ex) {
                    $query->where('course_title', 'like', $ex)
                    ->orWhere('categories_selection', 'like', $ex)
                    ->orWhere('c_level', 'like', $ex);
                })
                ->select('course_title')->orderByDesc('created_at')->take(10)->get();
            $data = [];
            if ($res && $res->count()) {
                foreach ($res as $s) {
                    array_push($data, $s->course_title);
                }
            } else {
                $users = User::where('name', 'like', "%" . $q . "%")->select('name')->orderByDesc('created_at')->take(10)->get();
                if ($users && $users->count()) {
                    foreach ($users as $user) {
                        array_push($data, $user->name);
                    }
                }
            }
            return response()->json($data);
        } catch (\Throwable $th) {
            return back();
        }
    }
    public function userSearch(Request $request)
    {
        try {
            $searched_keyword = $request->search_course;
            if (!$searched_keyword) {
                return back();
            }

            return redirect()->route('s-search-page', ['keyword' => $searched_keyword]);
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function showSearchCourse($keyword)
    {
        try {
            if (!$keyword) {
                return back();
            } else if (is_xss($keyword)) {
                abort(403);
            }

            $title = $keyword;
            $courses = Course::where('course_title', 'like', '%' . $keyword . '%')->where('status', 'published')
                ->whereNull('is_deleted')
                ->orderByDesc('created_at')->simplePaginate(15);

            if (!$courses->count()) {
                $user = User::where('name', $keyword)->select('id')->first();
                if ($user->count()) {
                    $courses = Course::where('user_id', $user->id)->whereNull('is_deleted')
                    ->where('status', 'published')->
                    orderByDesc('created_at')->simplePaginate(15);
                }
            }


            return view('xuesheng.show-course', compact('title', 'courses', 'keyword'));
        } catch (\Throwable $th) {
            return redirect()->route('index');
        }
    }

}
