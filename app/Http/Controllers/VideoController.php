<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseStatus;
use App\Models\Media;
use App\Models\Lecture;
use App\Models\ResVideo;
use App\Classes\LyskillsCarbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Helpers\uploadData;

class VideoController extends Controller
{
    public function __construct() {
        $this->uploadData = new uploadData;
        $this->uploadData = $this->uploadData->uploadVid();
        $this->st_path = "storage";
    }
    function validate_user($course_id){
        return Course::where([['user_id',Auth::id()],['id', $course_id]])->firstOrFail();
    }
    
    public function set_video_free(Request $request, $media_id)
    {
        try{
            $media = Media::where("id",$media_id)->first();
            if(!empty($media)){
            $set_free = !empty($request->set_free) ? 1 : 0;
            $set_download = !empty($request->set_download) ? 1 : 0;

            $media->is_free = $set_free;

            $media->is_download = $set_download;

            $media->save();
            $debug = "";
            if(config("app.debug")){
                $debug = ["media_id" => $media->id,
                "set_free" => $media->set_free,
                "old_set_free" => $set_free
            ];
            }
            return response()->json([
                'success' => true,
                "media_title" => $media->lec_name,
                "debug" => $debug
            ]);
            }else{
                return response()->json([
                    'err' => config("setting.err_msg",400),
                ]);
            }
        }
        catch(Exception $e){
            if(config("app.debug")){
                dd($e->getMessage());
            }else{
                return response()->json([
                    'err' => config("setting.err_msg",400),
                ]);
            }
        }
    }
    public function upload_video($course_id,$lecture_id,Request $request)
    {
        php_config();
        if($request->ajax()){
            try{
            $course = $this->validate_user($course_id);
            Lecture::findOrFail($lecture_id);

            $request->validate([
                'upload_video' => 'required|max:4500000|mimetypes:video/mp4,video/webm,video/ogg'
            ]);
            $file = $request->file('upload_video');
            $f_name = $file->getClientOriginalName();
            $f_mimetype = $file->getClientMimeType();

            $path1 = $file->store('uploads','public');

            $path = "uploads";
            $path = $this->uploadData->upload($file, $f_name);

            $getID3 = new \getID3;
            $file = $getID3->analyze(public_path('storage/'.$path1));

            $time_mili = !empty($file) && !empty($file['playtime_seconds']) ? $file['playtime_seconds'] : 2;

            $duration = LyskillsCarbon::parse($time_mili,$toTimeString=true);
            if(file_exists(public_path('storage/'.$path1))){
                // @ supress the error
                @unlink(public_path('storage/'.$path1));
            }
            $media = new Media;
            $media->lecture_id = $lecture_id;
            $media->lec_name = $path;
            $media->f_name = $f_name;
            $media->course_id = $course_id;
            $media->f_mimetype = $f_mimetype;
            $media->duration = $duration ;
            $media->time_in_mili = $time_mili ;
            $media->is_free = !empty($request->set_free) ? 1 : 0;
            $media->is_download = !empty($request->set_download) ? 1 : 0;
            $media->save();

            $c_status = CourseStatus::where('course_id',$course_id)->first();
            if($c_status){
                $path = config('setting.s3Url'). $path;
                $c_status->curriculum = 40;
                $c_status->save();
            }

            $course->updated_at = now();
            $course->save();
            return response()->json([
                'path' => $path,
                'media' => $media,
                'delete' => route('delete_video',['course_id'=>$course_id, 'media_id' => $media->id]),
                'f_name' => reduceCharIfAv($f_name,30)
            ]);
        }catch(Exception $d){
            return server_logs($e=[true,$d], $request=[true,$request],$config=true);
        }

        }else{
            abort(403);
        }
    }

    public function delete_video(Request $request,$course_id,$media_id){
        if($request->ajax()){
            $this->validate_user($course_id);
            $media = Media::findOrFail($media_id);
            $lec_id = $media->lecture_id;

            if($media){
                $file_name = $media->lec_name;
                    $media->delete();
                    return response()->json([
                        'status' => 'video has been deleted',
                        'video_url' => route('upload_video',['course_id' => $course_id, 'lecture_id' => $lec_id])
                    ]);
            }
        }
    }

    public function delete_uploaded_video(Request $request,$lec_id)
    {
        if($request->ajax()){
            $lec = ResVideo::findOrFail($lec_id);
            $this->validate_user($lec->lecture->course->id);
            if($lec){
                $file_name = $lec->lec_path;
                // debug_dump($file_name);
                if($file_name){
                    // $f_path = public_path('storage/'.$file_name);
                $f_path = Storage::disk('s3')->exists($file_name);
                    if($f_path){
                        // unlink($f_path);
                       Storage::disk('s3')->delete($f_path);

                    }
                    $lec->delete();
                    return response()->json([
                        'status' => 'video has been deleted',
                        'upload_video_url' => route('upload_vid_res',['lec_id' => $lec->lecture->id])
                    ]);
                }else{
                    return response()->json([
                        'error' => 'video was not deleted because of some issues'
                    ]);
                }
            }
        }

    }

    public function uploadBulkLoader(Request $request, $course){
        if($request->ajax()){
            $request->validate([
                'upload_b_vid.*' => 'required|max:4000000|mimetypes:video/mp4,video/webm,video/ogg'
            ]);

            $course = Course::findOrFail($course);
            $files = $request->file('upload_b_vid');

            foreach ($files as $file) {
                $f_name = $file->getClientOriginalName();
                $f_mimetype = $file->getClientMimeType();

                $path = $file->store('uploads','public');
                $media = new Media;
                $media->lec_name = $path;
                $media->f_name = $f_name;
                $media->f_mimetype = $f_mimetype;
                $media->course_id = $course->id;
                $media->save();
            }
            return response()->json(
               'All video files have been saved'
            );

        }else{
            abort(403);
        }
    }

    public function edit_video($course_id,$media_id,Request $request){
        php_config();
        if($request->ajax()){
            try{
            $course = $this->validate_user($course_id);

            $request->validate([
                'edit_video' => 'required|max:4500000|mimetypes:video/mp4,video/webm,video/ogg'
            ]);
            $file = $request->file('edit_video');
            $f_name = $file->getClientOriginalName();
            $f_mimetype = $file->getClientMimeType();

            $path1 = $file->store('uploads','public');

            $path = "uploads";

            $path = $this->uploadData->upload($file, $f_name);


            $getID3 = new \getID3;
            $file = $getID3->analyze(public_path($this->st_path.$path1));

            $time_mili = !empty($file) && !empty($file['playtime_seconds']) ? $file['playtime_seconds'] : 2;

            $duration = LyskillsCarbon::parse($time_mili,$toTimeString=true);
            if(file_exists(public_path($this->st_path.$path1))){
                // @ supress the error
                @unlink(public_path($this->st_path.$path1));
            }
            $media = Media::where("id", $media_id)->first();
            $media->lec_name = $path;
            $media->f_name = $f_name;
            $media->course_id = $course_id;
            $media->f_mimetype = $f_mimetype;
            $media->duration = $duration ;
            $media->time_in_mili = $time_mili ;
            $media->is_free = !empty($request->set_free) ? 1 : 0;
            $media->is_download = !empty($request->set_download) ? 1 : 0;
            $media->update();

            $course->updated_at = LyskillsCarbon::now();
            $course->save();
            return response()->json([
                'path' => $path,
                'media' => $media,
                'delete' => route('delete_video',['course_id'=>$course_id, 'media_id' => $media->id]),
                'f_name' => reduceCharIfAv($f_name,30)
            ]);
        }catch(Exception $d){
            return server_logs($e=[true,$d], $request=[true,$request],$config=true);
        }

        }else{
            abort(403);
        }
    }
}
