<?php

namespace App\Actions\Nouman;

use App\Mail\InformInstructorMail;
use App\Mail\StudentEnrollmentMail;
use App\Models\CourseEnrollment;
use App\Models\CourseHistory;
use App\Models\InstructorEarning;
use App\Models\Setting;
use Exception;
use Illuminate\Support\Facades\Mail;

class LyskillsPayment
{

    private $c_id;
    private $u_id;
    private $method;

    public function __construct($user_id, $course_id, $method)
    {
        $this->c_id = $course_id;
        $this->u_id = $user_id;
        $this->method = $method;
    }

    public function courseEnrollment($price_in_do, $ins_id, $is_free_access = false)
    {
        try {
            CourseEnrollment::create(['course_id' => $this->c_id, 'user_id' => $this?->u_id]);
            debug_logs("course enrollment done");
            CourseHistory::create([
                'course_id' => $this->c_id,
                'user_id' => $this->u_id,
                'pay_method' => $this->method,
                'amount' => $price_in_do,
                'ins_id' => $ins_id
            ]);
            debug_logs("course history done");
            if ($is_free_access === false) {
                $policy = Setting::select('payment_share_enable', 'instructor_share')->first();
                if ($policy && $policy->count() && $policy['payment_share_enable']) {
                    $earning = ((int) $policy['instructor_share'] * $price_in_do) / 100;
                } else {
                    $earning = (50 * $price_in_do) / 100;
                }
                InstructorEarning::create(['course_id' => $this->c_id, 'user_id' => $this->u_id, 'earning' => $earning, 'ins_id' => $ins_id]);
                debug_logs("instructor earning done");
            }
            return array('status' => true);
        } catch (Exception $e) {
            return array('status' => false, 'error' => $e->getMessage());
        }
    }

    public function sendEmail($email, $name, $slug, $course)
    {
        setEmailConfigForCourse();
        $course_url = route('user-course', $slug);

        Mail::to($email)->queue(new StudentEnrollmentMail($name, $course->course_title, $course_url));
        Mail::to($course->user->email)->queue(new InformInstructorMail($name, $course->course_title, $course_url, $course->user->name));
    }
}
