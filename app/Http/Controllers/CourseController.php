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

    }
