<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseDelHistory;
use App\Models\CourseEnrollment;
use App\Models\CourseHistory;
use App\Models\CourseStatus;
use App\Models\InstructorAnn;
use App\Models\InstructorEarning;
use App\Models\Lecture;
use App\Models\Section;
use App\Models\ResVideo;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;


class DashboardController extends Controller
{

    function validate_user($course_id)
    {
        return Course::where([['user_id', Auth::id()], ['id', $course_id]])->firstOrFail();
    }


    public function index()
    {
        try {
            if (!Auth::user()->is_instructor) {
                $user = User::findOrFail(Auth::id());
                if ($user) {
                    $user->is_instructor = 1;
                    $user->save();
                }
            }
            $ann = InstructorAnn::orderByDesc('created_at')->simplePaginate(3);
            $courses = Course::with(['course_image'])->where('user_id', Auth::id())->whereNull('is_deleted')
            ->select('id','user_id','course_title','status','slug','updated_at')->
            orderByDesc('created_at')->simplePaginate();
            $title = __('messages.dashboard');

            return view('dashboard', compact('courses', 'title', 'ann'));
        } catch (Exception $th) {
            return redirect()->route('index');
        }
    }


    public function show($course_id)
    {
        try {
            $course = $this->validate_user($course_id);
            $title = "target your students";
            return view('courses.dashboard_instructor', compact('course', 'course_id', 'title'));
        } catch (Exception $e) {
            return back()->with('error', 'there is a problem with this action. please report');
        }
    }

    public function save_record(Request $request)
    {
        $data = $request->all();
        $request->validate([
            'learnable_skill' => 'required',
            'course_requirement' => 'required',
            'targeting_student' => 'required',
        ]);



        if (count($data) > 1) {
            $course = Course::where('id', $data['course_id'])->where('user_id', Auth::id())->first();
            if (!$course) {
                abort(404);
            }

            if (array_key_exists("learnable_skill", $data)) {
                $course->learnable_skill = json_encode($data['learnable_skill']);
                $course->save();
            }

            if (array_key_exists("course_requirement", $data)) {

                $course->course_requirement = json_encode($data['course_requirement']);
                $course->save();
            }

            if (array_key_exists("targeting_student", $data)) {
                $course->targeting_student = json_encode($data['targeting_student']);
                $course->save();
            }

            $c_status = CourseStatus::where('course_id', $course->id)->first();
            if ($c_status) {
                $c_status->target_ur_students = 10;
                $c_status->save();
            }

            return response()->json(['status' => 'data has been saved']);
        } else {
            return response()->json(['status' => 'no extra data has been provided']);
        }
    }

    public function course_structure($course_id)
    {
        $course = $this->validate_user($course_id);
        return view('courses.course_structure', compact('course'));
    }

    public function course_setup($course_id)
    {
        $course = $this->validate_user($course_id);
        return view('courses.course_setup', compact('course'));
    }

    public function course_film($course_id)
    {
        $course = $this->validate_user($course_id);
        return view('courses.courses_film_edit', compact('course'));
    }

    public function course_curriculum($course_id)
    {

        $course = $this->validate_user($course_id);
        $section = Section::where('course_id', $course_id)
            ->get();
        return view('courses.course_curriculum', compact('course', 'section'));
    }

    public function course_curriculum_post(Request $request, $course_id)
    {
        $course  = $this->validate_user($course_id);
        if ($request->ajax()) {

            $section_title = $request->sec_title;
            if (strpos($section_title, '<script>') !== false) {
                return response()->json([
                    'error' => 'such type of input is not allowed',
                ], 422);
            }
            $sec_no =   check_input($request->sec_no);
            $sec_title = check_input($section_title);
            $rules = array('sec_title' => 'required|max:70', 'sec_no' => 'required|integer');
            $validator = Validator::make($request->all(), $rules);


            if ($validator->fails()) {
                return Response::json(
                    $validator->getMessageBag()->toArray(),
                    422
                );
            }

            $section = Section::where('course_id', $course_id)->where('section_no', $sec_no)->first();
            if ($section) {
                $section->section_title = $request->sec_title;
                $section->save();
                return response()->json([
                    'status' => 'saved',
                    'sec_title' => $sec_title,
                ], 200);
            } else {
                Section::create([
                    'course_id' => $course_id,
                    'section_no' => $sec_no,
                    'section_title' => $sec_title,
                ]);
                return response()->json([
                    'status' => 'saved',
                    'sec_title' => $sec_title,
                    'del_sec_url' => route('section_delete', ['course_id' => $course_id, 'section_id' => $sec_no])

                ], 200);
            }
        } else {
            abort(403);
        }
    }

    public function lec_name_post(Request $request, $course_id)
    {
        $course = $this->validate_user($course_id);
        if ($request->ajax()) {

            $validated = $request->validate([
                'lec_name' => 'required|max:255',
                'sec_no' => 'required'
            ]);

            $lec_name = $request->lec_name;
            $sec_no = $request->sec_no;

            if (strpos($lec_name, "<script>") !== false) {
                return response()->json([
                    'errors' => 'Did you really type the title correctly?',
                ], 403);
            }
            $lec_name = check_input($lec_name);
            $sec_no = check_input($sec_no);

            $lecture = new Lecture;
            $total_lecs = $lecture::where('course_id', $course_id)->count();
            ++$total_lecs;
            $lecture->course_id = $course_id;
            $lecture->lec_name = $lec_name;
            $lecture->lec_no = $total_lecs;
            $lecture->sec_no = $sec_no;

            $lecture->save();
            $lecture_id = $lecture->id;
            return response()->json([
                'lec_name' => $lec_name,
                'lec_no' => $total_lecs,
                'status_code' => 'Saved',
                'url'  => route('lecture_delete', ['course_id' => $course_id, 'lecture_id' => $lecture_id]),
                'video_url' => route('upload_video', ['course_id' => $course_id, 'lecture_id' => $lecture_id]),
                'add_desc' => route('add_desc', ['course_id' => $course_id, 'lec_id' => $lecture_id]),
                'res_video' => route('upload_vid_res', ['lec_id' => $lecture_id]),
                'article_url' => route('article', ['lec_id' => $lecture_id]),
                'ex_res_url' => route('ex_res', ['lec_id' => $lecture_id]),
                'other_files_url' => route('other_files', ['lec_id' => $lecture_id]),

            ], 200);
        } else {
            abort(403);
        }
    }


    public function upload_vid_res(Request $request, $lec_id)
    {
        $lecture = Lecture::findOrFail($lec_id);
        $course = $lecture->course;
        $course = $this->validate_user($course->id);
        if ($request->ajax()) {

            $request->validate([
                'upload_video' => 'required|max:4000000|mimetypes:video/mp4,video/webm,video/ogg'
            ]);
            $file = $request->file('upload_video');
            $f_name = $file->getClientOriginalName();
            $f_mimetype = $file->getClientMimeType();

            $path = $file->store('uploads', 'public');
            $media = new ResVideo;
            $media->lecture_id = $lec_id;
            $media->lec_path = $path;
            $media->f_name = $f_name;
            $media->f_mimetype = $f_mimetype;
            $media->save();

            $path = asset('storage/' . $path);

            return response()->json([
                'path' => $path,
                'media' => $media,
                'delete' => route('delete_uploaded_video', ['lec_id' => $media->id]),
                'f_name' => reduceCharIfAv($f_name, 30)
            ]);
        } else {
            abort(403);
        }
    }

    public function lec_name_edit_post(Request $request, $course_id)
    {
        $course = $this->validate_user($course_id);
        if ($request->ajax()) {
            $validatedData = $request->validate([
                'updated_title' => ['required', 'max:255'],
                'lecture_no' => ['required'],
            ]);

            $lec_no = $request->lecture_no;
            $lec_name = $request->updated_title;

            if (strpos($lec_name, "<script>") !== false || strpos($lec_no, "<script>") !== false) {
                return response()->json([
                    'errors' => 'Did you really type the title correctly?',
                ], 403);
            }

            $lecture = Lecture::where('course_id', $course_id)->where('lec_no', $lec_no)->first();
            $lecture->lec_name = $lec_name;
            $lecture->save();
            return response()->json([
                'status' => 'Title has been updated',
                'course_title' => $lec_name
            ], 200);
        }
    }

    public function course_delete($course_id)
    {
        try {
            $is_admin = false;
            if (isCurrentUserAdmin()) {
                $course = Course::findOrFail($course_id);
                $is_admin = true;
            } else {
                $course = $this->validate_user($course_id);
            }

            $course_en = CourseEnrollment::where('course_id', $course_id)->exists();
            if (!$is_admin && $course_en) {
                $course->is_deleted = true;
                $course->save();
                
                // course deletion history
                $this->delCourseHistory($course,$is_admin);

                return redirect()->route('dashboard')->with('status', 'Course has been deleted successfully!');
            }

            // dd('hit');
            $sections = $course->section;
            if ($sections && $sections->count()) {
                foreach ($sections as $section) {
                    $section->delete();
                }
            }

            // dd('hit');
            $course_img = $course->course_image;
            if ($course_img) {
                // dd($course_img);
                $img = $course_img->img_path;
                
                if (file_exists(asset('storage/'.$img))) {
                    unlink(public_path('storage/'. $img));
                }
                $course_img->delete();
            }


            $course_vid = $course->course_vid;
            if ($course_vid) {
                $vid = $course_vid->vid_path;
                if (file_exists(public_path('storage/').$vid)) {
                    // unlink(public_path('storage/') . $vid);
                }
                $course_vid->delete();
            }

            $courseEnrollments = $course->courseEnrollment;
            if ($courseEnrollments && $courseEnrollments->count()) {
                foreach ($courseEnrollments as $courseEnrollment) {
                    $courseEnrollment->delete();
                }
            }

            $wishlists = $course->wishlist;
            if ($wishlists && $wishlists->count()) {
                foreach ($wishlists as $wishlist) {
                    $wishlist->delete();
                }
            }

            $course_ens = CourseEnrollment::where('course_id', $course->id)->get();
            if ($course_ens && $course_ens->count()) {
                foreach ($course_ens as $c_en) {
                    $c_en->delete();
                }
            }

            $course_ens = InstructorEarning::where('course_id', $course->id)->get();
            if ($course_ens && $course_ens->count()) {
                foreach ($course_ens as $c_en) {
                    $c_en->delete();
                }
            }
            $course_ens = CourseHistory::where('course_id', $course->id)->get();
            if ($course_ens && $course_ens->count()) {
                foreach ($course_ens as $c_en) {
                    $c_en->delete();
                }
            }

            // CourseHistory::where('course_id',$course->id)->delete();

            $this->delCourseHistory($course,$is_admin);
            $course->delete();
            return redirect()->route('dashboard')->with('status', 'Course has been deleted successfully!');
        } catch (\Throwable $e) {
            return back()->with('error', 'this action cannot be done now '.$e->getMessage());
        }
    }

    private function delCourseHistory($course,$isAdmin)
    {
        $exist = CourseDelHistory::where('course_id',$course->id)->exists();
        if(!$exist){
            $logged_in_person = auth()->user();
            $name = $logged_in_person->name;
            $email = $logged_in_person->email;
            $course_del = new CourseDelHistory;
            $course_del->course_id = $course->id  ?? 0;
            $course_del->course_name = $course->course_title ?? 'Unknown Course Name';
            $course_del->person_name = $name ?? 'Unknown Person';
            $course_del->email = $email ?? 'Unknown Email';
            $course_del->is_admin = $isAdmin ?? '';
            $course_del->save();

        }

        return true;
    }


    public function lecture_delete($course_id, Lecture $lecture_id)
    {
        $this->validate_user($course_id);
        // delete video, desc, and resources.
        $this->deleteLec($lecture_id);

        $lecture_id->delete();
        $desc = $lecture_id->description();
        if ($desc) {
            $desc->delete();
        }

        $assignment = $lecture_id->assign;
        if ($assignment) {
            foreach ($assignment as $assign) {
                $ass_desc = $assign->ass_desc;
                if ($ass_desc) {
                    $ass_desc->delete();
                }
                $assign->delete();
            }
        }

        $quizzes = $lecture_id->quizzs;
        if ($quizzes) {
            foreach ($quizzes as $quiz) {
                $qzz_q = $quiz->quizzes;
                if ($qzz_q) {
                    foreach ($qzz_q as $qa) {
                        $qa->delete();
                    }
                }
                $quiz->delete();
            }
        }
        return back()->with('status', 'lecture has been deleted!');
    }

    public function section_delete($course_id, $section_id)
    {
        $course = $this->validate_user($course_id);
        if ($section_id != "1") {
            $sec = Section::where('section_no', $section_id)->where('course_id', $course_id);
            if ($sec) {
                $sec->delete();
            }
            $lecs = Lecture::where('course_id', $course_id)->where('sec_no', $section_id)->get();

            if ($lecs->count()) {
                foreach ($lecs as $lec) {
                    $lec_id = $lec->id;
                    $this->deleteLec($lec);

                    $lec->delete();
                }
            }

            return response()->json([
                'status' => 'section has been deleted',
            ]);
        }
    }

    private function deleteLec($lec)
    {
        $media = $lec->media;
        if ($media) {
            $lec_name = $media->lec_name;
            if ($lec_name) {
                $path = public_path('storage/' . $lec_name);
                if (file_exists($path)) {
                    unlink($path);
                }
                $media->delete();
            }

            $desc = $lec->description;
            if ($desc) {
                $desc->delete();
            }

            $res = $lec->res_vid;
            if ($res) {
                $lec_path = $res->lec_path;
                if ($lec_path) {
                    $path = public_path('storage/' . $lec_path);
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
                $res->delete();
            }

            $article = $lec->article;
            if ($article) {
                $article->delete();
            }

            $ex_res = $lec->ex_res;
            if ($ex_res) {
                $ex_res->delete();
            }

            $other_file = $lec->other_file;
            if ($other_file) {
                $saved_f_name = $other_file->saved_f_name;
                if ($saved_f_name) {
                    $path = public_path('storage/' . $saved_f_name);
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
                $other_file->delete();
            }
        }
    }
}
