<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseStatus;
use App\Models\Media;
use App\Models\Lecture;
use App\Models\ResVideo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class VideoController extends Controller
{   
    function validate_user($course_id){
        return Course::where([['user_id',Auth::id()],['id', $course_id]])->firstOrFail();
    }
    public function upload_video(Request $request,$course_id,$lecture_id)
    {
        try {
            if($request->ajax()){
                $course = $this->validate_user($course_id);
                Lecture::findOrFail($lecture_id);
                $request->validate([
                    'upload_video' => 'required|max:4000000|mimetypes:video/mp4,video/webm,video/ogg'
                ]);
                $file = $request->file('upload_video');
                $f_name = $file->getClientOriginalName();
                $f_mimetype = $file->getClientMimeType();
                
                $path = $file->store('uploads','public');
                
                $getID3 = new \getID3;
                $file = $getID3->analyze(public_path('storage/').$path);
                $time_mili = $file['playtime_seconds'];
                $duration = Carbon::parse($time_mili)->toTimeString();            
    
                $media = new Media;
                $media->lecture_id = $lecture_id;
                $media->lec_name = $path;            
                $media->f_name = $f_name;            
                $media->course_id = $course_id;            
                $media->f_mimetype = $f_mimetype;   
                $media->duration = $duration ;         
                $media->time_in_mili = $time_mili ;         
                $media->save();
                
                $c_status = CourseStatus::where('course_id',$course_id)->first();            
                if($c_status){
                    $path = asset('storage/'. $path);
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
    
            }else{
                abort(403);
            }
        } catch (\Exception $th) {
            return 
            response()->json(['errors' => ['upload_video' => 'Video was not uploaded because of some issue. Please try again '.$th->getMessage()]],500);
        }
    }

    public function delete_video(Request $request,$course_id,$media_id){
      try {
        if($request->ajax()){
            $this->validate_user($course_id);
            $media = Media::findOrFail($media_id);
            $lec_id = $media->lecture_id;
            
            if($media){
                $file_name = $media->lec_name;
                if($file_name){
                    $f_path = public_path('storage/'.$file_name);
                    if(file_exists($f_path)){
                        unlink($f_path);
                    }
                    $media->delete();
                    return response()->json([
                        'status' => 'video has been deleted',
                        'video_url' => route('upload_video',['course_id' => $course_id, 'lecture_id' => $lec_id])                                    
                    ]);
                }else{
                    return response()->json([
                        'error' => 'video was not deleted because of some issues'
                                   
                    ]);
                }
            }
        }
      } catch (\Throwable $th) {
          return back();
      }
    }

    public function delete_uploaded_video(Request $request,$lec_id)
    {
       try {
        if($request->ajax()){            
            $lec = ResVideo::findOrFail($lec_id);
            $this->validate_user($lec->lecture->course->id);
            if($lec){
                $file_name = $lec->lec_path;
                if($file_name){
                    $f_path = public_path('storage/'.$file_name);
                    if(file_exists($f_path)){
                        unlink($f_path);
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
       } catch (\Throwable $th) {
           return back();
       }

    }

    public function uploadBulkLoader(Request $request, $course){
        try {
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
        } catch (\Throwable $th) {
            return back();
        }
    }
}
