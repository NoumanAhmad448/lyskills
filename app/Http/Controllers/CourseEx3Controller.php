<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\Nouman\LyskillsPayment;
use App\Events\CourseStatusEmail;
use App\Http\Requests\CourseAnnRequest;
use App\Mail\PublicAnnByIns;
use App\Mail\StudentEmail;
use App\Models\Categories;
use App\Models\Chat;
use App\Models\ChatInfo;
use App\Models\Comment;
use App\Models\Course;
use App\Models\CourseAnnouncement;
use App\Models\CourseEnrollment;
use App\Models\CourseStatus;
use App\Models\Media;
use App\Models\OfflineEnrollment;
use App\Models\Promotion;
use App\Models\RatingModal;
use App\Models\User;
use App\Rules\IsScriptAttack;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use App\Classes\LyskillsCarbonClass;

class CourseEx3Controller extends Controller
{
    public function __construct() {
    }

    public function setting(Course $course)
    {
        try {
            $title = 'c_status';
            return view('courses.change-course-status-setting', compact('title', 'course'));
        } catch (\Throwable $th) {
            if(config("app.env")){
                dd($th->getMessage());
            }else{
                return back();
            }        }
    }

    public function PostSetting(Course $course)
    {
        try {
            if (Auth::user()->id == $course->user_id) {

                $course->status = "unpublished";
                $course->save();
                return back()->with('status', 'Course has been unpublished. After making changing, you  may resubmit it again.');
            }
        } catch (\Throwable $th) {
            if(config("app.env")){
                dd($th->getMessage());
            }else{
                return back();
            }
        }
    }

    public function delCourseSetting(Course $course)
    {
        try {
            if (Auth::user()->id == $course->user_id) {
                $course->status = "delete";
                $course->save();
                return redirect()->route('dashboard')->with('status', 'Course ' . reduceCharIfAv($course->course_title, 10) . ' has deleted');
            }
        } catch (\Throwable $th) {
            if(config("app.env")){
                dd($th->getMessage());
            }else{
                return back();
            }
        }
    }

    public function changeURL(Request $request, Course $course)
    {
        try {
            $request->validate([
                'slug' => 'required|unique:courses',
            ]);


            if ($course->user->id != auth()->user()->id || $course->has_u_update_url) {
                abort(403);
            }


            $slug = Str::slug($request->slug);
            $course->slug = $slug;
            $course->has_u_update_url = 1;
            $course->save();

            return back()->with('status', 'course url has been updated and it will not be updated in future');
        } catch (\Throwable $th) {
            if(config("app.env")){
                dd($th->getMessage());
            }else{
                return back();
            }
        }
    }

    public function  showCourse($slug)
    {
        try {
            $course = Course::with('lang:id,name')->where('slug', $slug)->first();
            if (!$course) {
                abort(404);
            }

            $total_en = CourseEnrollment::where("course_id", $course->id)->count();

            $title = $course->course_title;
            $desc = $course->description;
            $course_img = $course->course_image;
            if ($course_img) {
                $c_img = $course_img->image_path;
            } else {
                $c_img = "";
            }
            $rating_avg = (float) RatingModal::where('course_id',$course->id)->avg('rating');
            $rated_by_students = (int) RatingModal::where('course_id',$course->id)->count('rating');

            $comments = Comment::with('rating')->where('course_id',$course->id)->limit(3)->get();

            return view(config("setting.show_course_blade"), compact('comments','course', 'title', 'total_en', 'desc', 'c_img','rating_avg',
                    'rated_by_students'
        ));
        } catch (\Throwable $th) {
            if(config('app.debug'))
                dd($th->getMessage());
        }
    }

    public function showVideo($slug, $video)
    {

        try {
            $title = "course content";
            $id = auth()->id();

            $course = Course::with(['rating' =>  function($query) use($id){
                $query->where('student_id', (string)$id)->orderBy('created_at','desc');
            }])->where('slug', $slug)->first();

            if (!$course) {
                abort(404);
            }
            $media = Media::where('lec_name', 'uploads/' . $video)->first();
            if (!$media) {
                abort(404);
            }
            $u_id = auth()->id();
            $c_en = CourseEnrollment::where('user_id', $u_id)->where('course_id', $course->id)->first();
            if (allowCourseToAdmin() || $course->user->id === $u_id || ($c_en && $c_en->count())) {
                $lec_desc = $course->lecture->description;
                if ($lec_desc) {
                    $desc = $lec_desc->descripion;
                } else {
                    $desc = '';
                }
                $m_lec = $media->lecture;
                $c_anns = CourseAnnouncement::select('subject', 'body')->where('course_id', $course->id)->latest()->take(5)->get();
                $should_usr_hv_acs = true;
                if ($media->access_duration && $c_en && LyskillsCarbonClass::diffInDays($c_en->created_at,$media->access_duration)){
                    $should_usr_hv_acs = false;
                }
                return view('xuesheng.course-content', compact('course', 'title', 'media', 'desc', 'm_lec', 'c_anns','should_usr_hv_acs'));
            } else {
                abort(403);
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function showAllCourses()
    {
        try {
            $title = 'Courses';
            $courses = Course::with(['course_image', 'price', 'user'])->where('status', 'published')->where('is_deleted',NULL)->select(
                'id',
                'user_id',
                'course_title',
                'categories_selection',
                'slug'
            )->orderByDesc('created_at')->simplePaginate();
            return view('xuesheng.all-courses', compact('title', 'courses'));
        } catch (Exception $th) {
            return back()->with('error', 'this action cannot be done now. please try again');
        }
    }
    public function publicAnn()
    {
        try {
            $title = "public announcement";
            $courses = Course::where('user_id', auth()->id())->where('status', '=', 'published')->select('slug', 'course_title')->get();
            if (!$courses->count()) {
                return back()->with('error', 'You do not have any course to send users announcement');
            }
            return view('laoshi.public-announcement', compact('title', 'courses'));
        } catch (\Throwable $th) {
            if(config("app.env")){
                dd($th->getMessage());
            }else{
                return back();
            }
        }
    }
    public function publicAnnPost(CourseAnnRequest $request)
    {
        try {
            $request->validated();
            $user_id = auth()->id();

            $courses_slug = $request->courses;
            $users_email = array();
            $ann_detail = $request->except('_token', 'courses');

            if ($courses_slug) {
                foreach ($courses_slug as $slug) {
                    $course = Course::where('slug', $slug)->where('status', 'published')->where('user_id', $user_id)->first();
                    if ($course) {
                        $c_ann = CourseEnrollment::where('course_id', $course->id)->get();
                        if ($c_ann) {
                            foreach ($c_ann as $c) {
                                $u = $c->user;
                                if ($u) {
                                    $e = $u->email;
                                    if ($e) {
                                        $users_email[] = $e;
                                    }
                                    $ann_detail['course_id']   = $course->id;
                                }
                            }
                        }
                        CourseAnnouncement::create($ann_detail);
                    } else {
                        abort(403);
                    }
                }
            }

            setEmailConfigViaIns(auth()->user()->name);
            foreach ($users_email as $recipient) {
                Mail::to($recipient)->send(new PublicAnnByIns($request->subject, $request->body));
            }

            return back()->with('status', "Announcement has been made successfully");
        } catch (Exception $e) {
            return back()->with('error', "Announcement was not made successfully. Please try again");
        }
    }

    public function contactIns()
    {
        try {
            $title = "Contact With Instructor";
            $c_titles = [];
            $c_enrollment = CourseEnrollment::where('user_id', auth()->id())->select('course_id')->get();
            if ($c_enrollment->count()) {
                foreach ($c_enrollment as $en) {
                    $course_title = $en->course->value('slug');
                    array_push($c_titles, $course_title);
                }
            }

            return view('xuesheng.contact_with_ins', compact('title', 'c_titles'));
        } catch (\Throwable $th) {
            if(config("app.debug")){
                dd($th->getMessage());
            }
        }
    }
    public function contactInsPost(Request $request)
    {
        try {
            $request->validate([
                'course' => ['required', new IsScriptAttack],
                'body' => ['required', new IsScriptAttack]
            ]);

            $r_user_id = Course::where('slug', $request->course)->where('status', "published")->first()->user()->value('id');
            $s_user_id = auth()->id();
            Chat::create(['f_user_id' => $s_user_id, 'r_user_id' => $r_user_id, 'message' => $request->body]);
            $available = ChatInfo::where('user_id', $s_user_id)->where('ins_id', $r_user_id)->first();
            if (!$available) {
                ChatInfo::create(['user_id' => $s_user_id, 'ins_id' => $r_user_id]);
            }

        } catch (Exception $th) {
            if(config("app.env")){
                dd($th->getMessage());
            }else{
                return back()->with('error', 'something went wrong.');
            }
        }
    }

}
