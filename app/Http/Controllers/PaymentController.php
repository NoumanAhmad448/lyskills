<?php

namespace App\Http\Controllers;

use App\Mail\InformInstructorMail;
use App\Mail\PaymentMail;
use App\Mail\StudentEnrollmentMail;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\CourseHistory;
use App\Models\InstructorEarning;
use App\Models\MonthlyPaymentModel;
use App\Models\OfflinePayment;
use App\Models\Setting;
use App\Models\User;
use App\Rules\IsScriptAttack;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Promotion;

class PaymentController extends Controller
{
    public function couponPrice($request,$course,$extras,$updateCoupon=false)
    {
        if($request->session()->exists("coupon_".$course->id.auth()->id())){
            $coupon_ob = json_decode($request->session()->get("coupon_".$course->id.auth()->id()));
            $extras['course_price'] = $coupon_ob->final_price;
            $extras['course_discount'] = $coupon_ob->promotion->percentage;
            if($updateCoupon){
                $coupon = Promotion::where('course_id', $course)->where('coupon_code', $coupon_ob->promotion->coupon_code)->first();
                $coupon->no_of_coupons = $coupon->no_of_coupons -1;
                $coupon->save();

                // delete the session
                $request->session()->forget("coupon_".$course->id.auth()->id());
            }
        }
        return $extras;
    }
    public function availablePayMe(Request $request,$slug)
    {
        try {
            $title = "Available Payment Methods";
            $course = Course::where([['slug', $slug], ['status', 'published']])->with(["price" => function($price){
                $price->whereNotNull("is_free");
            }])->firstOrFail();
            if(empty($course->price))
            {
                return back()->with('error','course has no price');
            }
            $of_p_methods = OfflinePayment::first();
            $setting = Setting::select('s_is_enable', 'j_is_enable', 'e_is_enable', 'paypal_is_enable')->first();
            $request = $request;
            $request["user_id"] = auth()->id();
            $extras = [];
            $extras['course_price'] = $course->price->pricing;
            $extras = $this->couponPrice($request,$course,$extras);
            return view('xuesheng.available_payment', compact('title', 'slug', 'of_p_methods', 'setting','course',
                        "extras"));
        } catch (\Throwable $th) {
            if(config("app.debug")){
                dd($th->getMessage());
            }else{
                return back()->with('error', config("setting.err_msg"));
            }
        }
    }

    public function creditPayment(Request $request,$slug)
    {
        try {
            $course = Course::where('slug', $slug)->where('status', 'published')->firstOrFail();
            $title = "Credit Card";
            // $intent = $request->user()->createSetupIntent();
            // dd($intent);
            $extras = [];
            $extras['course_price'] = $course->price->pricing;
            $extras = $this->couponPrice($request,$course,$extras);
            return view('xuesheng.credit-card', compact('title', 'slug','course',"extras"));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function creditPaymentPost($slug, Request $request)
    {
        try {

            $course = Course::where('slug', $slug)->where('status', 'published')->firstOrFail();

            $payment_method = $request->payment_method;
            $price_in_do = $course->price->pricing;
            $extras = $this->couponPrice($request,$course,[],true);
            if(!empty($extras['course_price'])){
                $price_in_do = $extras['course_price'];
            }
            dd($price_in_do);
            if ($payment_method !== NULL) {

                $request->user()->charge(
                    $price_in_do * 100,
                    $payment_method
                );
                $u_id = auth()->id();
                $c_id = $course->id;

                CourseEnrollment::create(['course_id' => $c_id, 'user_id' => $u_id]);
                CourseHistory::create(['course_id' => $c_id, 'user_id' => $u_id, 'pay_method' => 'Stripe', 'amount' => $price_in_do, 'ins_id' => $course->user->id]);

                $policy = Setting::first();

                if ($policy->count() && $policy['payment_share_enable']) {
                    $earning = (((int) $policy['instructor_share']) * $price_in_do) / 100;
                    InstructorEarning::create(['course_id' => $c_id, 'user_id' => $u_id, 'earning' => $earning, 'ins_id' => $course->user->id]);
                    // dd('HIT');
                } else {
                    $earning = (50 * $price_in_do) / 100;
                    InstructorEarning::create(['course_id' => $c_id, 'user_id' => $u_id, 'earning' => $earning, 'ins_id' => $course->user->id]);
                }

                setEmailConfigForCourse();
                $course_url = route('user-course', $slug);
                // dd($course->user->email);
                Mail::to(auth()->user()->email)->queue(new StudentEnrollmentMail(auth()->user()->name, $course->course_title, $course_url));
                Mail::to($course->user->email)->queue(new InformInstructorMail(auth()->user()->name, $course->course_title, $course_url, $course->user->name));

                return back()->with('status', 'Congtratulation! your payment was made successfully. Now you may continue your course
                    by visiting your course page and clicking on start course button.');
            } else {
                return back()->with('error', 'something is going wrong. please try again');
            }
        } catch (Exception $e) {
            return back()->with('error', 'your payment was not made SUCCESSFULLY. please try again');
        }
    }

    public function paymentHis()
    {
        try {
            $title = "Payment History";
            $course_history = CourseHistory::select('id', 'course_id', 'ins_id', 'amount', 'pay_method', 'created_at')->where('user_id', auth()->id())->get();
            if ($course_history) {
                $course_history->load(['course:id,course_title,slug', 'ins:id,name']);
            }
            return view('student.payment_history', compact('title', 'course_history'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function purHis()
    {
        try {
            $title = "Course Earning History";
            $course_history = InstructorEarning::select('id', 'course_id', 'user_id', 'earning', 'created_at')->where('ins_id', auth()->id())->get();
            if ($course_history) {
                $course_history->load(['course:id,course_title', 'user:id,name']);
            }
            $t_earning = InstructorEarning::where('ins_id', auth()->id())->sum('earning');

            return view('laoshi.kuai_history', compact('title', 'course_history', 't_earning'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function sendEmailToInstructor(Request $request)
    {
        try {
            $request->validate([
                'user' => ['required', new IsScriptAttack]
            ]);

            $ins = User::findOrFail($request->user)->select('id', 'name', 'email')->first();
            $month  = Carbon::now()->month - 1;

            $save_detail = MonthlyPaymentModel::where('user_id', $request->user)->where('month', $month)->whereYear('created_at', Carbon::now()->year)->exists();
            if ($save_detail) {
                return back()->with('error', 'you have already paid for this month to this instructor');
            }

            setEmailConfigViaAdmin();
            Mail::to($ins->email)->queue(new PaymentMail($ins->name, $ins->email));

            $payment = InstructorEarning::whereMonth('created_at', $month)->sum('earning');
            $data = ['user_id' =>  $request->user, 'month' => $month, 'payment' => $payment];
            MonthlyPaymentModel::create($data);

            return back()->with('status', 'Heads up! payment has been made successfully');
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function newEnrollment()
    {
        try {
            $courses = Course::with('user:id,name,email')->where('status', 'published')->select('id', 'user_id', 'course_title', 'slug')->get();

            return view('admin.published-courses', compact('courses'));
        } catch (Exception $e) {
            return back()->with('error', 'some problem has been found');
        }
    }

    public function enrollment($course)
    {
        try {

            if (isAdmin()) {
                Course::where('id',$course)->whereNull('is_deleted')->where('status','published')->firstOrFail();
                $title = "enro_his";
                $users = CourseEnrollment::with('user:id,name,email')->where('course_id', $course)->select('id', 'user_id')->get();

                $total_enrollment = CourseEnrollment::where('course_id', $course)->count();
                $course_id = $course;
                return view('admin.course-enrollment-page', compact('users', 'title', 'course_id','total_enrollment'));
            }
        } catch (\Throwable $th) {
            if(config("app.debug")){
                dd($th->getMessage());
            }else{
                return back()->with('error', 'problem occured');
            }
        }
    }
}
