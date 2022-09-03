<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactUsRequest;
use App\Mail\ContactUsMail;
use App\Models\Categories;
use App\Models\Course;
use App\Models\Faq;
use App\Models\Post;
use App\Models\Page;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $title = __('messages.site_title');
            $desc = __('description.home');
            $cs = Categories::select('id', 'name', 'value')->get();
            $post = Post::where('status', 'published')->select('id', 'title', 'message', 'upload_img', 'f_name', 'slug')->orderByDesc('created_at')->first();
            $faq = Faq::where('status', 'published')->select('id', 'title', 'message', 'upload_img', 'f_name', 'slug')->orderByDesc('created_at')->first();
            $courses = Course::where('status', 'published')->whereNull('is_deleted')->with(['price:id,course_id,pricing,is_free', 'user:id,name', 'course_image'])->select('id', 'user_id', 'course_title', 'categories_selection', 'slug')->orderByDesc('created_at')->paginate(16);


            return view('welcome', compact('title', 'desc', 'cs', 'post', 'faq', 'courses'));
        } catch (Exception $e) {
            return back()->with('error', 'action cannot be performed now');
        }
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

            $next = Post::find($post->id + 1);
            $prev = Post::find($post->id - 1);
            return view('public_post.view_post', compact('post', 'title', 'next', 'prev', 'desc', 'c_img'));
        } catch (\Throwable $th) {
            return back();
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
            $next = FAQ::find($faq->id + 1);
            $prev = FAQ::find($faq->id - 1);
            return view('public_post.view_faq', compact('faq', 'title', 'next', 'prev', 'desc', 'c_img'));
        } catch (\Throwable $th) {
            //throw $th;
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

    public function logout(Request $request)
    {
        try {
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect('/')->with('status', 'you are logged out');
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function posts()
    {
        try {
            $title = __('messages.post');
            $desc = __('description.posts');
            $posts = Post::where('status', 'published')->orderByDesc('created_at')->simplePaginate(15);
            return view('public_post.posts', compact('title', 'posts', 'desc'));
        } catch (Exception $th) {
        }
    }

    public function contactUs()
    {
        try {
            $title = "contact us";
            $desc = __('description.contact_us');

            return view('xuesheng.contact-us', compact('title', 'desc'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function contactUsPost(ContactUsRequest $request)
    {
        try {

            $request->validated();
            // dd($request->all());
            Mail::to('lyskills.info@gmail.com')->queue(new ContactUsMail(
                $request->name,
                $request->email,
                $request->mobile ?? '',
                $request->country ?? '',
                $request->subject,
                $request->body
            ));

            return back()->with('status', 'Your Message has delivered. We will contact you soon');
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
            $res = DB::table('courses')->whereNull('is_deleted')->where('course_title', 'like', $ex)->orWhere('categories_selection', 'like', $ex)->orWhere('c_level', 'like', $ex)
                ->where('status', 'published')->select('course_title')->orderByDesc('created_at')->take(10)->get();
            $data = [];
            if ($res && $res->count()) {
                foreach ($res as $s) {
                    array_push($data, $s->course_title);
                }
            } else {
                $users = User::where('name', 'like', "%" . $q . "%")->select('name')->orderByDesc('created_at')->take(10)->get();
                if ($users->count()) {
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
