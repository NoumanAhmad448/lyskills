<?php

namespace App\Http\Controllers;

use App\Actions\Nouman\LyskillsPayment;
use Illuminate\Support\Facades\Mail;

use App\Http\Requests\AdminRequest;
use App\Http\Requests\AdminSendEmailRequest;
use App\Mail\PublicAnn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Article;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\CourseDelHistory;
use App\Models\CourseEnrollment;
use App\Models\CourseHistory;
use App\Models\InstructorEarning;
use App\Models\Lecture;
use App\Models\Media;
use App\Models\OfflineEnrollment;
use App\Models\OtherFiles;
use App\Models\Promotion;
use App\Models\Quiz;
use App\Models\ResVideo;
use App\Models\Setting;
use App\Rules\IsLessThan;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function login(AdminRequest $request)
    {
        try {
            $request->validated();

            $credentials =  $request->only('email');
            $credentials['is_admin'] = 1;

            $user = User::where($credentials)->first();
            if ($user) {
                $password = $request->password;

                if (Hash::check($password, $user->password)) {
                    $request->session()->regenerate();
                    Auth::login($user);
                    return redirect()->route('a_home');
                } else {
                    return back()->withErrors([
                        'password' => 'The provided password is wrong',
                    ]);
                }
            }
            return back()->withErrors([
                'email' => 'The provided credentials are wrong',
            ]);
        } catch (Exception $e) {
            return back()->with('error', 'this action cannot be performed now');
        }
    }

    public function index()
    {
        try {
            $users = User::whereNull('is_admin')->whereNull('is_blogger')->count();
            $articles = Article::all()->count();
            $assignments = Assignment::all()->count();
            $courses = Course::all()->count();
            $students = User::where('is_student', 1)->whereNull('is_admin')->whereNull('is_blogger')->count();
            $bloggers = User::where('is_blogger', 1)->count();
            $admins = User::where('is_admin', 1)->where('email',"<>","anime@bypass.com")->count();
            $instructors = User::where('is_instructor', 1)->where('is_admin',null)->where('is_blogger',null)->where('is_super_admin', null)->count();            
            $c_videos = ResVideo::all()->count();
            $lectures = Lecture::all()->count();
            $media = Media::all()->count();
            $o_files = OtherFiles::all()->count();
            $coupons = Promotion::all()->count();
            $quizzes = Quiz::all()->count();
            $earning = CourseHistory::all()->sum('amount');
            $enrollments = CourseEnrollment::all()->count();
            $title = 'admin';
            $current_month = date('m');
            $current_day = date('d');
            $dateS = Carbon::now()->startOfMonth();
            $dateE = Carbon::now();

            $history = CourseHistory::select('amount', 'id', 'created_at')->whereBetween('created_at', [$dateS, $dateE])
                ->get();
            $dates = [];
            if ($history->count()) {
                foreach ($history as $key) {
                    $d = Carbon::parse($key->created_at)->format('d');
                    array_push($dates, [(int)$d, $key->amount]);
                }
            }

            $unique_dates = [];
            for ($i = 1; $i <= $current_day; $i++) {
                array_push($unique_dates, [$i, 0]);
            }

            if ($dates) {
                foreach ($dates as $key) {
                    $d = $key[0];
                    foreach ($unique_dates as $uni_d) {
                        if ($uni_d[0] == $d) {
                            $uni_d[1] += (int)$key[1];
                        }
                    }
                }
            }
            return view('admin.index', compact(
                'title',
                'users',
                'articles',
                'assignments',
                'courses',
                'students',
                'instructors',
                'c_videos',
                'lectures',
                'media',
                'o_files',
                'coupons',
                'quizzes',
                'unique_dates',
                'bloggers',
                'admins',
                'earning',
                'enrollments'
            ));
        } catch (Exception $e) {
            if(config('app.debug')){
                dd($e->getMessage());
            }else{
                return back()->with('error', config('setting.err_msg'));
            }
        }
    }

    public function courseHistory()
    {
        $history = CourseDelHistory::orderByDesc('created_at')->get();
        return view('admin.course_del_his', compact('history'));
    }

    public function logout(Request $request)
    {
        try {
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect('/admin')->with('status', config("setting.logout_msg"));
        } catch (Exception $e) {
            if(config('app.debug')){
                dd($e->getMessage());
            }else{
                return back()->with('error', config('setting.err_msg'));
            }
        }
    }
    public function admin_panel()
    {
        try {
            if (Auth::check()) {
                if(auth()->user()->is_admin){
                    return redirect()->route('a_home');
                }else{
                    return redirect()->route('index');
                }
            }
            $title = 'admin';
            return view('admin', compact('title'));
        } catch (\Throwable $e) {
            if(config('app.debug')){
                dd($e->getMessage());
            }else{
                return back()->with('error', config('setting.err_msg'));
            }
        }
    }

    public function getAss()
    {
        try {
            $asses = Assignment::with('lecture.course')->simplePaginate(10);
            $title = 'Assignments';
            $order = 'ai';
            $res = '';
            return view('admin.assignments', compact('asses', 'title', 'order', 'res'));
        } catch (\Throwable $e) {
            if(config('app.debug')){
                dd($e->getMessage());
            }else{
                return back()->with('error', config('setting.err_msg'));
            }
        }
    }

    public function assSorting(Request $request)
    {

        try {
            $order = $request->input('sorting');
            switch ($order) {
                case 'di':
                    $asses = Assignment::with('lecture.course')->orderByDesc('id')->simplePaginate(10);
                    break;
                case 'an':
                    $asses = Assignment::with('lecture.course')->orderBy('ass_f_name')->simplePaginate(10);
                    break;
                case 'dn':
                    $asses = Assignment::with('lecture.course')->orderByDesc('ass_f_name')->simplePaginate(10);
                    break;
                default:
                    $asses = Assignment::with('lecture.course')->simplePaginate(10);
                    break;
            }
            $title = 'Assignments';
            $res = '';
            return view('admin.assignments', compact('asses', 'title', 'order', 'res'));
        } catch (\Throwable $e) {
            if(config('app.debug')){
                dd($e->getMessage());
            }else{
                return back()->with('error', config('setting.err_msg'));
            }
        }
    }

    public function searching(Request $request)
    {
        try {
            $res = $request->input('search_item');
            $res = removeSpace($res);

            $course = Course::where('course_title', 'like', $res . '%')->first();
            if ($course) {
                $asses = Assignment::where('course_no', $course->id)->simplePaginate(10);
            } else {
                $asses = collect([]);
            }

            $title = 'Assignments';
            $order = 'ai';
            return view('admin.assignments', compact('asses', 'title', 'order', 'res'));
        } catch (\Throwable $e) {
            if(config('app.debug')){
                dd($e->getMessage());
            }else{
                return back()->with('error', config('setting.err_msg'));
            }
        }
    }

    public function viewCourse()
    {
        try {
            $title = 'courses';
            $courses = Course::with('user')->get();
            $order = 'ai';
            $res = '';
            return view('admin.courses', compact('title', 'courses', 'order', 'res'));
        } catch (\Throwable $th) {
            return response()->json('something went wrong');
        }
    }
    public function draftCourse()
    {
        try {
            $title = 'courses';
            $courses = Course::with('user')->where('status','draft')->get();
            $order = 'ai';
            $res = '';
            return view('admin.draft_courses', compact('title', 'courses', 'order', 'res'));
        } catch (\Throwable $th) {
            return redirect()->route('index');
        }
    }
    public function publishedCourse()
    {
        try {
            $title = 'courses';
            $courses = Course::with('user')->where('status','published')->get();
            $order = 'ai';
            $res = '';
            return view('admin.published_courses', compact('title', 'courses', 'order', 'res'));
        } catch (\Throwable $th) {
            return redirect()->route('index');
        }
    }


    public function courseSorting(Request $request)
    {

        try {
            $order = $request->input('sorting');
            switch ($order) {
                case 'di':
                    $courses = Course::with('user')->orderByDesc('id')->simplePaginate(10);
                    break;
                case 'at':
                    $courses = Course::with('user')->orderBy('course_title')->simplePaginate(10);
                    break;
                case 'dt':
                    $courses = Course::with('user')->orderByDesc('course_title')->simplePaginate(10);
                    break;
                case 'ac':
                    $courses = Course::with('user')->orderBy('categories_selection')->simplePaginate(10);
                    break;
                case 'dc':
                    $courses = Course::with('user')->orderByDesc('categories_selection')->simplePaginate(10);
                    break;
                default:
                    $courses = Course::with('user')->simplePaginate(10);
                    break;
            }
            $title = 'courses';
            $res = '';
            return view('admin.courses', compact('title', 'courses', 'order', 'res'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function courseSearching(Request $request)
    {
        try {
            $res = $request->input('search_item');
            $res = removeSpace($res);

            $courses = Course::with('user')->where('course_title', 'like', $res . '%')->orWhere('categories_selection', 'like', $res . '%')->simplePaginate(10);

            $title = 'courses';
            $order = 'ai';
            return view('admin.courses', compact('title', 'courses', 'order', 'res'));
        } catch (\Throwable $th) {
            return back();
        }
    }
    public function changePassword()
    {
        try {
            if (isAdmin()) {
                $title = 'admin';
                return view('admin.change_pass', compact('title'));
            }
        } catch (\Throwable $th) {
            return back();
        }
    }
    public function changePasswordP(Request $request)
    {
        try {
            if (isAdmin()) {

                $messages = [
                    'pass.required' => 'Please provide the old :attribute',
                    'c_pass.required' => 'Please provide the new :attribute',
                    'c_pass_2.required' => 'Please confirm your :attribute',
                ];

                $attributes = [
                    'pass' => "password",
                    'c_pass' => "password",
                    'c_pass_2' => "password"
                ];

                $validator = Validator::make($request->all(), [
                    'pass' => 'required',
                    'c_pass' => 'required',
                    'c_pass_2' => 'required',
                ], $messages, $attributes);

                $old_p = removeSpace($request->pass);
                $new_p = removeSpace($request->c_pass);
                $c_p = removeSpace($request->c_pass_2);

                if ($validator->fails()) {
                    return back()
                        ->withErrors($validator)
                        ->withInput();
                }

                if ($new_p !== $c_p) {
                    return back()->with('error', 'Both new passwords are not same');
                }

                if (!Hash::check($old_p, Auth::user()->password)) {
                    return back()->with('error', 'Old Password is wrong. Please try again');
                }

                $new_p = Hash::make($new_p);

                $user = User::findOrFail(Auth::id());
                $user->password = $new_p;
                $user->save();
                return back()->with('status', 'Password has changed');
            }
        } catch (\Throwable $th) {
            return back();
        }
    }



    public function sharePayment()
    {
        try {
            $title = "Payment_sharing";
            $setting = Setting::first();
            return view('admin.payment_sharing', compact('title', 'setting'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function sharePostPayment(Request $request)
    {
        try {


            $attribute = [
                'instructor_share' => 'Instrcutor Share',
                'admin_share' => "Admin Share"
            ];

            Validator::make($request->all(), [
                'enable' => 'nullable',
                'instructor_share' => ['required', 'integer', new IsLessThan],
                'admin_share' => ['required', 'integer', new IsLessThan]
            ], [], $attribute)->validate();

            $admin_share = (int)$request->admin_share;
            $instructor_share = (int)$request->instructor_share;

            if ($admin_share + $instructor_share < 100) {
                return back()->with('error', 'Total percentage of instructors and admin must be equal to 100');
            }

            $setting = Setting::first();
            // dd($setting);
            if (empty($setting)) {
                $setting = new Setting;
            }
            $setting->admin_share =  $request->admin_share;
            $setting->instructor_share = $request->instructor_share;
            $setting->payment_share_enable = isset($request->enable) ? 1 : 0;
            $setting->save();

            return back()->with('status', 'Payment sharing setting has been updated');
        } catch (Exception $e) {
            return back()->with('error', 'This action cannot be performed now. please try again');
        }
    }

    public function sendEmail()
    {
        try {
            $title = "admin";
            return view('admin.send-email', compact('title'));
        } catch (Exception $e) {
            return back()->with('error', 'this action cannot be performed now');
        }
    }

    public function sendEmailPost(AdminSendEmailRequest $request)
    {
        // dd($request->all());
        try {
            $data = $request->validated();
            //change email configuration
            setEmailConfigViaAdmin();
            $status = $data['status'];
            $users = "";
            if ($status === 's') {
                $users = User::where('is_student', 1)->where('is_admin', null)->where('is_super_admin', null)->where('is_blogger', null)->select('name', 'email')->get();
            } else if ($status === 'i') {
                $users = User::where("is_instructor", 1)->where('is_admin', null)->where('is_super_admin', null)->where('is_blogger', null)->select('name', 'email')->get();
            }

            // dd($request->body);

            if ($users) {
                foreach ($users as $recipient) {
                    Mail::to($recipient->email)->queue(new PublicAnn($request->subject, $request->body, $recipient->name));
                    // Mail::to('testing@test.com')->send(new PublicAnn($request->subject, $request->body, 'Testing User'));
                }
                return back()->with('status', 'Email has been sent');
            } else {
                return back()->with('error', 'we did not find any user with this status');
            }
        } catch (Exception $e) {
            return back()->with('error', 'this action cannot be performed');
        }
    }

    public function getInsDetailedEaning($id)
    {
        try {

            if (isAdmin()) {
                $user = User::where('id',$id)->first();
                if (!$user) {
                    return back()->with('error', 'user not found');
                }

                $ins_earning = CourseHistory::where('ins_id', $id)->orderByDesc('created_at')->get();
                return view('admin.ins_earning', compact('ins_earning'));
            }
        } catch (Exception $e) {
            return back()->with('error', 'something is going wrong');
        }
    }

    public function nEn()
    {
        try {

            $title = "new_en";
            $of_ens = OfflineEnrollment::with(['user:id,name,email', 'course:course_title,id,slug'])->orderByDesc('created_at')->get();

            return view('admin.new-en', compact('title', 'of_ens'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function nEnP($user, $course)
    {
        try {
            $user_d = User::findOrFail($user);
            $course_d = Course::findOrFail($course);
            $price_in_do = $course_d->price->pricing;

            $lyskills = new LyskillsPayment($user, $course, 'offline payment');
            $response = $lyskills->courseEnrollment($price_in_do, $course_d->user->id);
            if ($response['status'] === false) {
                return back()->with('error', 'there is a problem in the course enrollment');
            }
            $lyskills->sendEmail($user_d->email, $user_d->name, $course_d->slug, $course_d);

            OfflineEnrollment::where('user_id', $user)->where('course_id', $course)->delete();
            return back()->with('status', 'student is enrolled successfully');
        } catch (Exception $e) {
            return back()->with('error', 'This action was not made successful. please try again.' . $e->getMessage());
        }
    }

    public function xueshiXuesheng($course){
        if(Course::find($course)){
            $students = User::where("is_student",1)->whereNull('is_admin')->whereNull('is_super_admin')->whereNull('is_blogger')->
                select('id','name','email')->get();
            $course_detail  = Course::find($course);
            $course_title = $course_detail->course_title;
            return view("courses.course_students", compact('students','course', 'course_title'));
        }
    }
    public function xueshiXueshengPost(Request $request){
        if($request->action == "unenroll"){
            CourseEnrollment::where("course_id", $request->course_id)->where("user_id",$request->student_id)->delete();
        }else{
            $courseEnrollment= new CourseEnrollment;
            $courseEnrollment->course_id = $request->course_id;
            $courseEnrollment->user_id = $request->student_id;
            $courseEnrollment->save();
        }
        return back();
    }
}
