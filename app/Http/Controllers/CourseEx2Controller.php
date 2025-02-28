<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseEx2Controller extends Controller
{

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
            $found_coupon = Promotion::where('course_id', $course)->where('coupon_code', $coupon);
            if ($found_coupon->exists() === false) {
                return back()->with('error', 'this coupon does not exist');
            }
            $coupon = $found_coupon->first();
            // coupon is free for life time
            $F_COURSE_ID = 'course_id';
            $F_USER_ID = 'user_id';
            $course_detail = Course::where("id", $course)->with(["price" => function($price){
                $price->whereNotNull('is_free');
            }])->first();

            if(empty($course_detail->price)){
                return back()->with('error', 'Coupons are only for paid courses');
            }
            $user = auth()->id();
            if($coupon->is_free){
                // check date
                if($this->isCouponInValid($coupon)){
                    return back()->with('error', 'This coupon is expired');
                }
                if($coupon->no_of_coupons && $coupon->no_of_coupons > 0)
                {
                    $coupon->no_of_coupons = $coupon->no_of_coupons -1;
                    $coupon->save();
                }
                if(!CourseEnrollment::where($F_COURSE_ID, $course)->where($F_USER_ID , $user)->exists()){
                    CourseEnrollment::create([$F_COURSE_ID => $course, $F_USER_ID => $user]);
                }

                return back()->with('status', 'Congtratulation! you are enrolled in this course now');
            }
            else if($coupon->percentage)
            {
                if($this->isCouponInValid($coupon)){
                    return back()->with('error', 'This coupon is expired');
                }else{
                    $new_price_ob = ["course_id" => $course, "course_ob" => $course_detail, "user_id" => $user, "user_ob" => auth()->user(),
                    "promotion" => $coupon , "final_price" => (int)$course_detail->price->pricing -
                    ($course_detail->price->pricing * ($coupon->percentage/100))];

                    $request->session()->put('coupon_'.$course.$user, json_encode($new_price_ob));
                    return redirect()->route("a_payment_methods",["slug" => $course_detail->slug]);
                }
            }
            else{
                return back()->with('error', 'There is no percentage set for this coupon. Please contact with your instructor again');
            }
        } catch (Exception $th) {
            if(config("app.debug")){
                dd($th->getMessage());
            }else{
                return back()->with('error', config("setting.err_msg"));
            }
        }
    }
    private function isCouponInValid($coupon)
    {
        return ($coupon->date_time && $coupon->date_time < date("Y-m-d")) ||
        ($coupon->no_of_coupons == "0");
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

}
