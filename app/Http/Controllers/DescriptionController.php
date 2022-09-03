<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Description;
use Illuminate\Support\Facades\Auth;


class DescriptionController extends Controller
{
    function validate_user($course_id)
    {
        try {
            return Course::where([['user_id', Auth::id()], ['id', $course_id]])->firstOrFail();
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function add_desc($course_id, $lec_id, Request $request)
    {
        try {
            if ($request->ajax()) {
                $course  = $this->validate_user($course_id);
                $request->validate([
                    'lec_desc' => 'required|max:1000',
                ]);
                $lec_desc = $request->lec_desc;
                if (is_xss($lec_desc)) {
                    return response()->json([
                        'error' => 'now allowed',
                    ]);
                }
                $lec_desc = check_input($lec_desc);

                $desc = Description::where('lecture_id', $lec_id)->first();

                if ($desc) {
                    $desc->description = $lec_desc;
                    $desc->save();

                    return response()->json([
                        'status' => 'updated successfully',
                        'lec_desc' => $lec_desc
                    ], 200);
                }
                $desc = new Description;
                $desc->lecture_id = $lec_id;
                $desc->description = $lec_desc;
                $desc->save();

                return response()->json([
                    'status' => 'saved successfully',
                    'lec_desc' => $lec_desc
                ], 200);
            }
        } catch (\Throwable $th) {
            return back();
        }
    }
}
