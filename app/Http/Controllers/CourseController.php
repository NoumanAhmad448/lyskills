<?php

namespace App\Http\Controllers;

use App\Actions\Nouman\LyskillsPayment;
use App\Events\CourseStatusEmail;
use App\Http\Requests\CourseAnnRequest;
use App\Mail\PublicAnnByIns;
use App\Mail\StudentEmail;
use App\Models\Categories;
use App\Models\Chat;
use App\Models\ChatInfo;
use App\Models\Comment;
use Illuminate\Http\Request;
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

class CourseController extends Controller
{
    public function index($id, $course_id)
    {
        try {
            if ($id == 1) {
                $course = Course::where('id', $course_id)->where('user_id', Auth::id())->first();
                if (!$course) {
                    abort(404);
                }
                $course_title = $course->course_title;
                return view('courses.course_title_selection', compact('id', 'course_id', 'course_title'));
            } else if ($id == 2) {
                $categories = Categories::all();
                return view('courses.course_categories_selection', compact('id', 'course_id', 'categories'));
            }
            else {
                abort(404);
            }
        }
        catch (\Throwable $th) {
            if(config("app.env")){
                dd($th->getMessage());
            }else{
                return back();
            }
        }

    }

    public function storeCourseDetail($id, $course_id, Request $request)
    {
        try {
            if ($id == 2) {
                $validatedData = $request->validate([
                    'course_title' => ['required', 'max:60'],
                ]);

                $course = Course::findOrFail($course_id);
                $course->update($validatedData);

                return redirect()->route('courses_instruction', ['id' => $id, 'course_id' => $course_id]);
            } else if ($id == 3) {

                $validatedData = $request->validate([
                    'categories_selection' => [
                        'required', Rule::notIn(['Choose a category'])
                    ],
                ]);

                $course = Course::findOrFail($course_id);
                $course->update($validatedData);

                return redirect()->route('courses_dashboard', compact('course_id'));
            }
        } catch (\Throwable $th) {
            if(config("app.env")){
                dd($th->getMessage());
            }else{
                if(config("app.env")){
                dd($th->getMessage());
            }else{
                return back();
            }
            }
        }
    }

    public function createCourse()
    {
        try {
            $course = new Course;
            $course->user_id =  Auth::id();
            $course->status = 'draft';
            $course->save();
            $course_status = new CourseStatus;
            $course_status->course_id = $course->id;

            if ($course_status->save()) {
                return redirect()->route('landing_page', compact('course'));
                return redirect()->route('courses_instruction', ['id' => 1, 'course_id' => $course->id]);
            } else {
                return back()->with('error', 'server error');
            }
        } catch (\Throwable $th) {
            if(config("app.env")){
                dd($th->getMessage());
            }else{
                return back()->with('error', 'server error');
            }
        }

    }

    public function changeStatus(Request $request)
    {
            $course_no = $request->course_no;
            $status = $request->status;

            $course = Course::findOrFail($course_no);
            switch ($status) {
                case 'p':
                    # published
                    $course->status = 'published';
                    $course->save();
                    // dispatch event for sending an email
                    $this->sendEmail($course);
                    return response()->json('course has been marked as published');
                    break;

                case 'b':
                    # block
                    $course->status = 'block';
                    $course->save();
                    // dispatch event for sending an email
                    $this->sendEmail($course);
                    return response()->json('course has been marked as block');
                    break;

                case 'pe':
                    # pending
                    $course->status = 'pending';
                    $course->save();
                    // dispatch event for sending an email
                    $this->sendEmail($course);
                    return response()->json('course has been marked as pending');
                    break;

                case 'mp':
                    # mark popular
                    $course->isPopular = true;
                    $course->save();
                    return response()->json('course has been marked as popular');
                    break;

                case 'rp':
                    # remove popular
                    $course->isPopular = false;
                    $course->save();
                    return response()->json('course has been removed from popular');
                    break;

                case 'mf':

                    $course->isFeatured = true;
                    $course->save();
                    return response()->json('course has been marked as featured');
                    break;

                case 'rf':

                    $course->isFeatured = false;
                    $course->save();
                    return response()->json('course has been removed from featured');
                    break;

                default:
                    # script attack
                    abort(403);
                    break;
            }
    }


    private function sendEmail($course)
    {
        try {
            CourseStatusEmail::dispatch($course);
        } catch (\Throwable $th) {
            if(config("app.env")){
                dd($th->getMessage());
            }else{
                if(config("app.env")){
                dd($th->getMessage());
            }else{
                return back();
            }
            }
        }
    }
    public function showPC()
    {
        try {
            $courses = Course::where('isPopular', 1)->simplePaginate(15);
            $title = 'p_courses';
            return view('admin.show_p_courses', compact('title', 'courses'));
        } catch (\Throwable $th) {
            if(config("app.env")){
                dd($th->getMessage());
            }else{
                if(config("app.env")){
                dd($th->getMessage());
            }else{
                return back();
            }
            }
        }
    }

    public function showFC()
    {
        try {
            $courses = Course::where('isFeatured', 1)->simplePaginate(15);
            $title = 'f_courses';
            return view('admin.show_f_courses', compact('title', 'courses'));
        } catch (\Throwable $th) {
            if(config("app.env")){
                dd($th->getMessage());
            }else{
                if(config("app.env")){
                dd($th->getMessage());
            }else{
                return back();
            }
            }
        }
    }

    public function newCourse()
    {
        try {
            $title = 'new_courses';
            $courses = Course::with('user')->where('status', 'pending')->simplePaginate(10);
            return view('admin.new_courses', compact('title', 'courses'));
        } catch (\Throwable $th) {
            if(config("app.env")){
                dd($th->getMessage());
            }else{
                if(config("app.env")){
                dd($th->getMessage());
            }else{
                return back();
            }
            }
        }
    }

    public function changePrice(Course $course)
    {
        try {
            if (isAdmin()) {
                $title = 'Change_Course';
                return view('admin.change-course-price', compact('course', 'title'));
            }
        } catch (\Throwable $th) {
            if(config("app.env")){
                dd($th->getMessage());
            }else{
                if(config("app.env")){
                dd($th->getMessage());
            }else{
                return back();
            }
            }
        }
    }
    public function changePricePost(Course $course, Request $request)
    {
        try {
            Validator::make($request->all(), [
                'price' => 'required|numeric',
            ])->validate();

            if (isAdmin()) {
                if ($course->price && $course->status == "published") {
                    $course->price->pricing = $request->price;
                    $course->price->is_free = 0;
                    $course->price->save();
                    return back()->with('status', 'price has been updated');
                } else {
                    return back()->with('error', 'Either course is not published yet or instructor did not provide the price yet');
                }
            }
        } catch (\Throwable $th) {
            if(config("app.env")){
                dd($th->getMessage());
            }else{
                return back();
            }
        }
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

                return view('xuesheng.course-content', compact('course', 'title', 'media', 'desc', 'm_lec', 'c_anns'));
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

    public function chatIns()
    {
        try {
            $title = 'Chat';
            $all_inss = ChatInfo::where('user_id', auth()->id())->select('ins_id')->get();
            return view('xuesheng.chat-history', ['title' => $title, 'all_inss' => $all_inss]);
        } catch (\Throwable $th) {
            if(config("app.env")){
                dd($th->getMessage());
            }else{
                return back();
            }
        }
    }
    public function emailToIns()
    {
        try {
            $title = "Email to Instructor";
            $c_titles = [];
            $c_enrollment = CourseEnrollment::where('user_id', auth()->id())->select('course_id')->get();
            if ($c_enrollment->count()) {
                foreach ($c_enrollment as $en) {
                    $course = $en->course()->where('status', 'published')->first();
                    $course_title = $course['slug'];
                    array_push($c_titles, $course_title);
                }
            }
            return view('xuesheng.send-email-to-ins', compact('title', 'c_titles'));
        } catch (\Throwable $th) {
            if(config("app.env")){
                dd($th->getMessage());
            }else{
                return back();
            }
        }
    }

    public function emailToInsPost(Request $request)
    {
        try {
            $request->validate([
                'subject' => ['required', new IsScriptAttack],
                'body' => ['required', new IsScriptAttack],
                'course' => ['required', new IsScriptAttack],
            ]);

            $ins = Course::where('slug', $request->course)->where('status', "published")->first()->user()->select('email', 'name')->first();

            $user = auth()->user();
            $u_name = $user->name;
            $u_email = $user->email;
            setEmailConfigViaStudent();

            Mail::to($ins['email'])->queue(new StudentEmail($u_name, $u_email, $request->course, $request->subject, $request->body, $ins['name']));
            return back()->with('status', 'Your Email has been sent to your instructor. If instructor wants to contact with you. He/She will respond 
        back to you on your email address.');
        } catch (Exception $th) {
            if(config("app.env")){
                dd($th->getMessage());
            }else{
                return back()->with('error', 'there is something wrong going on. please try again');
            }
        }
    }

    public function myLearning()
    {
        try {
            $title = "My Learning";
            $courses_list = CourseEnrollment::where('user_id', auth()->id())->distinct()->pluck('course_id');

            if ($courses_list) {
                $courses = Course::orderByDesc('created_at')->findOrFail($courses_list);
            }
            return view('xuesheng.my-learning', compact('title', 'courses'));
        } catch (\Throwable $th) {
            if(config("app.env")){
                dd($th->getMessage());
            }else{
                return back();
            }
        }
    }

    public function offlinePayment(Request $request)
    {
        try {
            $request->validate([
                'slug' => ['required', 'string']
            ]);

            $course = Course::where('slug', $request->slug)->select('id')->first();
            if (!$course) {
                abort(403);
            }
            $user_id = auth()->id();
            $c_id = $course->id;

            OfflineEnrollment::updateOrCreate(
                ['course_id' => $c_id, 'user_id' => $user_id],
                ['user_id' => $user_id]
            );

            return back()->with('status', 'your request has been received. please be patience! we will contact you soon');
        } catch (\Throwable $th) {
            if(config("app.env")){
                dd($th->getMessage());
            }else{
                return back();
            }
        }
    }
    public function getCerti(Request $request)
    {
        try {
            $request->validate([
                'c_name' => 'required'
            ]);
            $title = $request->c_name;
            if (!Course::where('course_title', $title)->first()) {
                abort(403);
            }
            $name = auth()->user()->name;
            return view('xuesheng.get_cert', compact('title', 'name'));
        } catch (Exception $e) {
            return back()->with('error', config("setting.err_msg"));
        }
    }

    public function coupon(Request $request)
    {
        try {
            $request->validate([
                'coupon' => ['required', new IsScriptAttack],
                'course' => ['required']
            ]);

            $coupon = $request->coupon;
            $course = $request->course;
            $found_coupon = Promotion::where('course_id', $course)->where('coupon_code', $coupon)->exists();
            if ($found_coupon === false) {
                return back()->with('error', 'this coupon does not exist');
            }

            $course_d = Course::findOrFail($course)->select('id', 'user_id', 'slug')->first();

            $user = auth()->id();
            CourseEnrollment::create(['course_id' => $course, 'user_id' => $user]);

            return back()->with('status', 'Congtratulation! you are enrolled in this course now');
        } catch (Exception $e) {
            return back()->with('error', config("setting.err_msg"));
        }
    }

    public function enrollNow(Request $request, $course)
    {
        try {

            $course_d = Course::findOrFail($course);

            if (isCurrentUserAdmin() || auth()->id() == $course_d->user_id || isCurrentUserBlogger()) {
                return back()->with('error', 'operation not allowed');
            }

            $user = auth()->id();

            $lyskills = new LyskillsPayment($user, $course, 'free');
            CourseEnrollment::Create(['course_id' => $course, 'user_id' => $user]);

            $user_d = User::findOrFail($user);

            $lyskills->sendEmail($user_d->email, $user_d->name, $course_d->slug, $course_d);

            return back()->with('status', 'Congtratulation! you are enrolled in this course now');
        } catch (Exception $th){
            if(config("app.debug")){
                dd($th->getMessage());
            }else{
                return back()->with('error', config("setting.err_msg"));
            }
        }
    }


    public function ratingCourse(Request $request)
    {
        try {
            $rating_no = $request->rating_no;
            $course_slug = $request->course;
            $course = Course::where('slug',$course_slug)->first();

            if(!$course){
                abort(403);
            }
            $c_id = $course->id;
            $user_id = auth()->id();
            $rating_modal = RatingModal::where([['student_id', '=', $user_id], ['course_id' , '=' , $c_id]])->first();
            if($rating_modal){
                $rating_modal->rating = $rating_no;
                $rating_modal->save();
            }else{
                RatingModal::Create(['course_id' => $c_id, 'student_id' => $user_id, 'rating' => $rating_no]);
            }

            return response()->json(['message' => 'done']);

        } catch (\Throwable $th) {
            return response()->json(['error' => config("setting.err_msg").$th->getMessage()],500);
        }
    }

    public function createPdf()
    {
         $cert_no = rand();
        $date = Carbon::now()->toDateString();
        $course_name = "";
        $d = ['course' => $course_name, 'cert_no' => $cert_no, 'date' => $date, 'name' => auth()->user()->name];
        return view('course.certificate', $d);
        return PDF::loadView()
                ->setPaper('a4', 'landscape')->setWarnings(false)
                ->download('certificate.pdf');
    }

    public function downloadCert($course_name){
        $cert_no = rand();
        $date = Carbon::now()->toDateString();

        $d = ['course' => $course_name, 'cert_no' => $cert_no, 'date' => $date, 'name' => auth()->user()->name];

        $path = asset('img/certificate.jpg');

        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $img = 'data:image/' . $type . ';base64,' . base64_encode($data);
        $d['img'] = $img;
        return PDF::loadView("course.certificate", $d)->setPaper('a4', 'landscape')->setWarnings(false)->
                        stream('certificate.pdf');
    }

    public function comment($course_name)
    {
        try {
            $course = Course::where('slug',$course_name)->where('status','published')->where('is_deleted',null)->first();
            if(!$course){
                return redirect()->route('index');
            }
            $logged_user = auth()->user();
            $comments = Comment::where('course_id', $course->id)->where('user_id',$logged_user->id)->orderByDesc('created_at')->get();

            return view('course.user-comment',compact('course','logged_user','comments'));
        } catch (\Throwable $th) {
            if(config("env.debug")){
                dd($th->getMessage());
            }else{
                return redirect()->route('index')->with('error',config("setting.err_msg"));
            }
        }
    }

    public function commentPost(Request $request)
    {
        $request->validate([
            'course_slug' => ['required','max:255',new IsScriptAttack],
            'message' => 'required',
        ]);
        try {
            Comment::create(['course_id' => $request->course_slug, 'user_id' => auth()->id(), 'comment' => $request->message]);
        } catch (\Throwable $th) {
            if(config("app.env")){
                dd($th->getMessage());
            }else{
                return back()->with('error', config("setting.err_msg"));
            }
        }
    }

    public function commentDelete(Request $request)
    {
        Comment::where('id',$request->message_id)->delete();
        return response()->json('done');
    }

    public function commentUpdate(Request $request)
    {
       try{
           $co = Comment::where('id',$request->comm_id)->first();
           $co->comment = $request->new_msg;
           $co->save();
        }
        catch(\Throwable $th){
            if(config("app.env")){
                dd($th->getMessage());
            }else{
                return back();
            }
        }
    }

    public function readComments($course)
    {
        $course = Course::where('id',$course)->first();
        if(!$course){
            return redirect()->route('dashboard');
        }
        $course_name = $course->course_title;
        $comms = Comment::where('course_id',$course->id)->get();
        return view('course.course-comment', compact('comms','course_name'));
    }
}
