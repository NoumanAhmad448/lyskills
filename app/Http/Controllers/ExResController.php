<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Lecture;
use App\Models\ExRes;
use Illuminate\Support\Facades\Validator;


class ExResController extends Controller
{
    public function validate_user($user_id)
    {
        try {
            return Auth::id() == $user_id;
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function link(Request $request, $lec_id)
    {
        try {
            if ($request->ajax()) {

                $lec = Lecture::findOrFail($lec_id);
                if (!$this->validate_user($lec->course->user_id)) {
                    abort(403);
                }

                $validator = Validator::make($request->all(), [
                    'ex_res_title' => 'bail|nullable|max:60',
                    'ex_res_link' => 'bail|nullable|url',
                ]);

                $ex_res_title = $request->ex_res_title;
                $ex_res_link = $request->ex_res_link;

                if (strpos($ex_res_title, "<script>") !== false) {
                    abort(403);
                }
                if (strpos($ex_res_link, "<script>") !== false) {
                    abort(403);
                }
                $ex_res_title = check_input($ex_res_title);
                $ex_res_link = check_input($ex_res_link);


                $ex_ex_data = ExRes::where('lecture_id', $lec_id)->first();
                if ($ex_ex_data) {
                    $ex_ex_data->title = $ex_res_title;
                    $ex_ex_data->link = $ex_res_link;
                    $ex_ex_data->save();

                    return response()->json([
                        'status' => 'Updated Information',
                    ]);
                }

                $validator->after(function ($validator) use ($request) {
                    if ($request->ex_res_title == '' || $request->ex_res_title == null) {
                        $validator->errors()->add(
                            'ex_res_title',
                            'This field is required'
                        );
                    } else if ($request->ex_res_link == '' || $request->ex_res_link == null) {
                        $validator->errors()->add(
                            'ex_res_link',
                            'This field is required'
                        );
                    }
                });

                if ($validator->fails()) {
                    response()->json(['error' => 'one or more fields are required'], 422);
                }

                $ex_res = new ExRes;
                $ex_res->title = $ex_res_title;
                $ex_res->link = $ex_res_link;
                $ex_res->lecture_id = $lec_id;
                $ex_res->save();

                return response()->json([
                    'status' => 'youtube link has been saved',
                ]);
            } else {
                abort(403);
            }
        } catch (\Throwable $th) {
            return back();
        }
    }
}
