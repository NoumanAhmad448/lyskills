<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lecture;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function validate_user($user_id)
    {
        try {
            return Auth::id() == $user_id;
        } catch (\Throwable $th) {
            return back();
        }
    }
    public function article(Request $request, $lec_id)
    {
        try {
            if ($request->ajax()) {

                $lec = Lecture::findOrFail($lec_id);
                if (!$this->validate_user($lec->course->user_id)) {
                    abort(403);
                }

                $request->validate([
                    'article_text' => 'required|max:1500',
                ]);

                $ar_text = $request->article_text;
                $ar_text = removeSpace($ar_text);

                if (strpos($ar_text, "<script>") !== false) {
                    abort(403);
                }
                $ar_text = check_input($ar_text);


                $existed_ar = Article::where('lecture_id', $lec_id)->first();
                if ($existed_ar) {
                    $existed_ar->article_txt = $ar_text;
                    $existed_ar->save();

                    return response()->json([
                        'status' => 'Updated article',
                    ]);
                }
                $ar = new Article;
                $ar->article_txt = $ar_text;
                $ar->lecture_id = $lec_id;
                $ar->save();

                return response()->json([
                    'status' => 'article has been saved',
                ]);
            } else {
                abort(403);
            }
        } catch (\Throwable $th) {
            return back();
        }
    }
}
