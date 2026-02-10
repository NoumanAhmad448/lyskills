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
use App\Helpers\UploadData;
use Illuminate\Support\Facades\Log;
use Carbon\CarbonInterval;

class VideoController extends Controller
{
    protected $uploadData;
    private $st_path;

    public function __construct() {
        $this->uploadData = new UploadData;
        $this->uploadData = $this->uploadData->enableVideoUploading();
        $this->st_path = "storage/";
    }

    public static function toSeconds($getId3)
    {
        // 1️⃣ Preferred: numeric seconds from getID3
        if (!empty($getId3['playtime_seconds'])) {
            return (int) round($getId3['playtime_seconds']);
        }

        // 2️⃣ Fallback: H:MM:SS string
        if (!empty($getId3['playtime_string'])) {
            return CarbonInterval::createFromFormat(
                'H:i:s',
                $getId3['playtime_string']
            )->totalSeconds;
        }

        return 0;
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

            // $duration = round($time_mili / 60, 2); // 2 minutes
            $duration = $this->toSeconds($file);
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
            // dd($path1);

            $path = "uploads";

            $path = $this->uploadData->upload($file, $f_name);


            $getID3 = new \getID3;
            $file = $getID3->analyze(public_path($this->st_path.$path1));
            // dd($file);
            $time_mili = !empty($file) && !empty($file['playtime_seconds']) ? $file['playtime_seconds'] : 0;
            if(empty($time_mili)){
                Log::alert("the object time_mili has an issue with file storage path. Please make sure file is being saved correctly. Check this->st_path. it should have slash in the end");
            }
            // dd($time_mili);
            // $duration = round($time_mili / 60, 2); // 2 minutes
            $duration = $this->toSeconds($file);
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
