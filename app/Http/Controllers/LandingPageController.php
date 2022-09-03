<?php

namespace App\Http\Controllers;

use App\Http\Requests\LandingPage;

use App\Http\Requests\CourseImageUpload;
use App\Http\Requests\CourseVideoRequest;
use App\Models\Categories;
use App\Models\Course;
use App\Models\CourseImage;
use App\Models\CourseStatus;
use App\Models\CourseVideo;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class LandingPageController extends Controller
{
    public function landing_page(Course $course)
    {
        try {
            if ($course->user_id == Auth::id()) {
                $categories = Categories::all();
                return view('courses.landing_page', compact('course', 'categories'));
            } else {
                abort(403);
            }
        } catch (\Throwable $th) {
            return back();
        }
    }
    public function store_landing_page(LandingPage $request, $course)
    {
        try {
            $request->validated();

            $course  = Course::findOrFail($course);

            $course_title = $request->course_title;
            $course_desc = $request->course_desc;
            $select_level = $request->select_level;
            $select_category = $request->select_category;


            if (is_xss($course_title) || is_xss($course_desc) || is_xss($select_level) || is_xss($select_category)) {
                abort(403);
            }

            $course->c_level = $select_level;
            $course->description = $course_desc;
            $course->course_title = $course_title;
            $course->categories_selection = $select_category;
            $course->lang_id = $request->lang;
            $course->save();

            changeCourseStatus($course->id, 20, 'landing_page');

            return response()->json([
                'status' => 'Your information has been saved',
            ]);
        } catch (\Throwable $th) {
            return back();
        }
    }


    public function course_img(CourseImageUpload $request, $course)
    {
        try {
            $request->validated();

            $file = $request->file('course_img');
            $manager = new ImageManager();
            $image = $manager->make($file)->resize(300, 200);


            // $path = $file->store('img','public');
            $name = $file->getClientOriginalName();
            $path = 'img/' . time() . uniqid() . explode(' ', $name)[0];
            $save_path = public_path('storage/img');
            if (!file_exists($save_path)) {
                mkdir($save_path);
            }
            $image->save(public_path('storage/' . $path));
            $extension = $file->extension();
            $course = Course::findOrFail($course);
            $course_img = $course->course_image;
            // dd($course_img);
            if ($course_img) {
                $prev_p = public_path('storage/' . $course_img->image_path);

                if ($prev_p) {
                    unlink($prev_p);
                }
                $course_img->image_path = $path;
                $course_img->image_name = $name;
                $course_img->image_ex = $extension;
                $course_img->save();

                return response()->json([
                    'status' => 'saved',
                    'img_path' => asset('storage/' . $path)
                ]);
            }

            $course_img = new CourseImage;
            $course_img->course_id = $course->id;
            $course_img->image_path = $path;
            $course_img->image_name = $name;
            $course_img->image_ex = $extension;
            $course_img->save();


            changeCourseStatus($course->id, 5, 'course_img');

            return response()->json([
                'status' => 'saved',
                'img_path' => asset('storage/' . $path)
            ]);
        } catch (Exception $e) {
            return back()->with('error', 'this action cannot be performed now. plz try again later ');
        }
    }


    public function course_vid(CourseVideoRequest $request, $course)
    {
        try {
            $request->validated();
            
            $course = Course::findOrFail($course);
            $file = $request->file('course_vid');
            // $file_path = $file->storePublicly('uploads', 's3');
            $file_path = 'uploads';
            $file_path = Storage::disk('s3')->put($file_path, $file);
            
            // dd($file_path);
            $f_mime_type = $file->getClientMimeType();
            $f_name = $file->getClientOriginalName();

            $course_vid = $course->course_vid;
            if ($course_vid) {
                // $p_path = public_path('storage/' . $course_vid->vid_path);
                $p_path = Storage::disk('s3')->exists($course_vid->vid_path);
                // if ($p_path && file_exists($p_path)) {
                if ($p_path ) {
                    // unlink();
                    // dd(Storage::disk('s3')->get($course_vid->vid_path));
                    Storage::disk('s3')->delete($course_vid->vid_path);

                }
                $course_vid->video_name = $f_name;
                $course_vid->video_type = $f_mime_type;
                $course_vid->vid_path = $file_path;
                $course_vid->save();


                // dd(gettype(Storage::get('file.jpg')));
                return response()->json([
                    // 'video_path' => asset('storage/' . $file_path),
                    'video_path' => Storage::disk('s3')->response($file_path),
                    'video_type' => $f_mime_type
                ]);
            } else {
                $c_vid = new CourseVideo;
                $c_vid->course_id = $course->id;
                $c_vid->video_name = $f_name;
                $c_vid->video_type = $f_mime_type;
                $c_vid->vid_path = $file_path;
                $c_vid->save();

                changeCourseStatus($course->id, 5, 'course_video');
                return response()->json([
                    // 'video_path' => asset('storage/' . $file_path),
                    'video_path' =>  Storage::disk('s3')->response($file_path),
                    'video_type' => $f_mime_type
                ]);
            }
        } catch (\Throwable $e) {
            return response()->json(['course_vid', ['Your video was not uploaded due to some issue. Please try again '.$e->getMessage()]],500);
        }
    }
}
