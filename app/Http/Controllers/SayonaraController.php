<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Sayonara;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SayonaraRequest;
use App\Models\CourseStatus;

class SayonaraController extends Controller
{
    public function sayonara(Course $course)
    {
        try {
            if ($course->user_id == Auth::id()) {
                return view('courses.sayonara', compact('course'));
            }
        } catch (\Throwable $th) {
            return back();
        }
    }


    public function storeSayonara(SayonaraRequest $request, $course)
    {
        try {
            $request->validated();
            $wel_msg = $request->wel_msg;
            $congo_msg = $request->congo_msg;

            if (is_xss($wel_msg) || is_xss($congo_msg) || !$request->ajax()) {
                abort(403);
            }
            $course = Course::findOrFail($course);

            $sayonara = $course->sayonara;
            if ($sayonara) {
                $sayonara->welcome_msg = $wel_msg;
                $sayonara->congo_msg = $congo_msg;
                $sayonara->save();
            } else {
                $sayonara = new Sayonara;
                $sayonara->course_id = $course->id;
                $sayonara->welcome_msg = $wel_msg;
                $sayonara->congo_msg = $congo_msg;
                $sayonara->save();
            }
            changeCourseStatus($course->id, 10, 'message');
            return response()->json([
                'status' => 'messages have been saved'
            ]);
        } catch (\Throwable $th) {
            return back();
        }
    }



    public function submitCourse(Course $course)
    {
        try {
            if ($course->user_id == Auth::id()) {
                $response = [];
                $c_status = CourseStatus::where('course_id', $course->id)->first();
                if ($c_status) {
                    if (!$c_status->target_ur_students) {
                        $response['target_ur_students'] = "Target your students section";
                    }

                    if (!$c_status->curriculum) {
                        $response['curriculum'] = "Curriculum section";
                    }

                    if (!$c_status->landing_page) {
                        $response['landing_page'] = "Landing Page section";
                    }

                    if (!$c_status->pricing) {
                        $response['pricing'] = "Pricing section";
                    }

                    if (!$c_status->message) {
                        $response['message'] = "Message section";
                    }

                    if (!$c_status->course_img) {
                        $response['course_img'] = "Course Image inside the landing page section";
                    }

                    if (!$c_status->course_video) {
                        $response['course_video'] = "Course Video inside the landing page section";
                    }

                    if (count($response)  === 0) {
                        $course->status = "pending";
                        $course->save();
                        return response()->json(['status' => 'success']);
                    }

                    return response()->json($response);
                }
            } else {
                abort(403);
            }
        } catch (\Throwable $th) {
            return back();
        }
    }
}
