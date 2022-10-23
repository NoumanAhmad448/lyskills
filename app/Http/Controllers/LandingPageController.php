<?php

namespace App\Http\Controllers;

use App\Http\Requests\LandingPage;

use App\Http\Requests\CourseImageUpload;
use App\Http\Requests\CourseVideoRequest;
use App\Models\Categories;
use App\Models\Course;
use App\Models\CourseImage;
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
            if(config("app.env")){
                dd($th->getMessage());
            }else{
                return back();
            }
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

            $name = $file->getClientOriginalName();
            $path = "storage/img/".time() . uniqid() . str_replace(' ', '-',$name);

            $dir_path = "storage/img";
            if(!Storage::disk("s3")->exists($dir_path)) {
                Storage::disk("s3")->makeDirectory($dir_path, 0775, true);
            }

            Storage::disk("s3")->put($path, $image->stream()->__toString());

            $extension = $file->extension();
            $course = Course::findOrFail($course);
            $course_img = $course->course_image;
            if ($course_img) {
                $prev_p = $course_img->image_path;

                if ($prev_p) {
                    Storage::disk("s3")->delete($prev_p);
                }
                $course_img->image_path = $path;
                $course_img->image_name = $name;
                $course_img->image_ex = $extension;
                $course_img->save();

                return response()->json([
                    'status' => 'saved',
                    'img_path' => config("setting.s3Url").$path,
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
                'img_path' => config("setting.s3Url").$path,
            ]);
        } catch (Exception $e) {
            if(config("app.debug")){
                dd($e->getMessage());
            }else{
                return response()->json([
                    'error' => config("setting.err_msg")
                ]);
            }
        }
    }


    public function course_vid(CourseVideoRequest $request, $course)
    {
        try {
            $request->validated();
            $course = Course::findOrFail($course);
            $file = $request->file('course_vid');

            ini_set('memory_limit','5096M');

            $file_path = 'uploads';
            $file_path = Storage::disk('s3')->put($file_path, $file);

            $f_mime_type = $file->getClientMimeType();
            $f_name = $file->getClientOriginalName();

            $course_vid = $course->course_vid;
            if ($course_vid) {
                $p_path = Storage::disk('s3')->exists($course_vid->vid_path);
                if ($p_path ) {
                    Storage::disk('s3')->delete($course_vid->vid_path);

                }
                $course_vid->video_name = $f_name;
                $course_vid->video_type = $f_mime_type;
                $course_vid->vid_path = $file_path;
                $course_vid->save();

                return response()->json([
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
                    'video_path' =>  Storage::disk('s3')->response($file_path),
                    'video_type' => $f_mime_type
                ]);
            }
        } catch (\Throwable $e) {
            return response()->json(['course_vid', ['Your video was not uploaded due to some issue. Please try again '.$e->getMessage()]],500);
        }
    }
}
