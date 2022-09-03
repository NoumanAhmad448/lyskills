<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Quiz;
use App\Models\QuizQuestionAns;
use App\Http\Requests\QuizPostRequest;
use App\Http\Requests\QuizQuestionPostRequest;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class QuizController extends Controller
{


    public function quiz(Request $request, Course $course)
    {
        try {
            $request->validate([
                'quiz_title' => 'required|max:255',
                'lec_no' => 'required'
            ]);

            $title = $request->quiz_title;
            if (strip_tags($title) === $title) {

                if ($course->user_id ==  Auth::id()) {


                    $lec_no = $request->lec_no;
                    if (strip_tags($lec_no) === $lec_no) {

                        $lec = Lecture::where('lec_no', $lec_no)->where('course_id', $course->id)->first();
                        $id = $lec->id;
                        $course_id = $course->id;
                        $count_quiz = Quiz::where('course_no', $course_id)->count();
                        $quiz = new Quiz;
                        $quiz->title = $title;
                        $quiz->lecture_id = $id;
                        $quiz->course_no = $course_id;
                        $quiz_no = $count_quiz ? $count_quiz += 1 : '1';
                        $quiz->quiz_no = $quiz_no;
                        $quiz->save();


                        return response()->json([

                            'quiz_no' => $quiz_no,
                            'quiz_title' => reduceCharIfAv($title, 30),
                            'title_edit' => route('update_quiz', ['quiz' => $quiz]),
                            'delete_quiz' => route('delete_quiz', ['quiz' => $quiz]),
                            'add_quiz_desc' => route('add_quiz_desc', ['quiz' => $quiz]),
                            'add_quizzs' => route('add_quizzs', ['quiz' => $quiz]),
                        ]);
                    }
                }
            }
        } catch (\Throwable $th) {
            return back();
        }
    }


    public function update(Request $request, Quiz $quiz)
    {
        try {
            $request->validate([
                'quiz_title' => 'required|max:255',
            ]);

            $title = $request->quiz_title;
            if (strip_tags($title) === $title) {
                $title = check_input($title);
                if ($quiz->lecture->course->user_id ==  Auth::id()) {

                    $quiz->title = $title;
                    $quiz->save();


                    return response()->json([
                        'status' => 'title has been updated',
                        'quiz_title' => reduceCharIfAv($quiz->title, 30),
                    ]);
                }
            }
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function delete(Quiz $quiz)
    {
        try {
            if ($quiz->lecture->course->user_id ==  Auth::id()) {

                $quiz->delete();
                $quizzes = $quiz->quizzes;
                if ($quizzes) {
                    foreach ($quizzes as $q) {
                        $q->delete();
                    }
                }

                return back()->with('status', 'quiz has been deleted');
            }
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function addDesc(Request $request, Quiz $quiz)
    {
        try {
            if ($request->ajax()) {

                $request->validate([
                    'quiz_desc_detail' => 'required|max:1000',
                ]);
                $quiz_desc_detail = $request->quiz_desc_detail;

                if (strip_tags($quiz_desc_detail) === $quiz_desc_detail) {
                    if ($quiz->lecture->course->user_id ==  Auth::id()) {
                        $quiz_desc_detail = check_input($quiz_desc_detail);
                        if ($quiz->quiz_desc) {
                            $quiz->quiz_desc = $quiz_desc_detail;
                            $quiz->save();

                            return response()->json([
                                'status' => 'updated successfully',
                                'quiz_desc_detail' => $quiz->quiz_desc
                            ], 200);
                        }
                        $quiz->quiz_desc = $quiz_desc_detail;
                        $quiz->save();

                        return response()->json([
                            'status' => 'saved successfully',
                            'quiz_desc_detail' => $quiz_desc_detail
                        ], 200);
                    }
                }
            }
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function addQuiz(QuizPostRequest $request, $quiz)
    {
        try {
            $request->validated();
            $quiz = Quiz::findOrFail($quiz);

            $question = $request->question;
            $ans1 = $request->ans1;
            $ans2 = $request->ans2;
            $ans3 = $request->ans3;
            $ans4 = $request->ans4;
            $reason_ans = $request->reason_ans;
            $ans = $request->ans;

            if (is_xss($question) && is_xss($ans1) && is_xss($ans2) && is_xss($ans3) && is_xss($ans4) && is_xss($ans) && is_xss($reason_ans)) {
                abort(403);
            }
            $quiz_id = $quiz->id;

            $c_q = QuizQuestionAns::where('quiz_id', $quiz_id)->count();
            if (!$c_q) {
                $c_q = 1;
            } else {
                $c_q++;
            }

            $qa = new QuizQuestionAns;
            $qa->quiz_id  = $quiz_id;
            $qa->course_id = $quiz->lecture->course->id;
            $qa->count_quizzes = $c_q;
            $qa->question = $question;
            $qa->ans1 = $ans1;
            $qa->ans2 = $ans2;
            $qa->ans3 = $ans3;
            $qa->ans4 = $ans4;
            $qa->reason_ans = $reason_ans;
            $qa->ans = $ans;
            $qa->save();

            return response()->json([
                'edit_url' => route('edit_quizzes', ['quizzes' => $qa]),
                'delete_url' => route('del_quizzes', ['quizzes' => $qa]),
                'quiz' => $qa,
                'status' => 'Quiz has been added'
            ]);
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function editQuizzes(QuizQuestionAns $quizzes)
    {
        try {
            return response()->json([
                'quizzes' => $quizzes,
                'update_quizzes' => route('update_quizzes', compact('quizzes'))
            ]);
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function updateQuiz(QuizQuestionPostRequest $request, $quizzes)
    {
        try {
            $request->validated();

            $qa = QuizQuestionAns::findOrFail($quizzes);

            $question = $request->question;
            $ans1 = $request->ans1;
            $ans2 = $request->ans2;
            $ans3 = $request->ans3;
            $ans4 = $request->ans4;
            $reason_ans = $request->reason_ans;
            $ans = $request->ans;

            if (is_xss($question) && is_xss($ans1) && is_xss($ans2) && is_xss($ans3) && is_xss($ans4) && is_xss($ans) && is_xss($reason_ans)) {
                abort(403);
            }

            $qa->question = $question;
            $qa->ans1 = $ans1;
            $qa->ans2 = $ans2;
            $qa->ans3 = $ans3;
            $qa->ans4 = $ans4;
            $qa->reason_ans = $reason_ans;
            $qa->ans = $ans;
            $qa->save();

            return response()->json([
                'quiz_title' => reduceCharIfAv($question, 30),
                'status' => 'Quiz has been updated'
            ]);
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function deleteQuizzes(QuizQuestionAns $quizzes)
    {
        try {
            if ($quizzes->quiz->lecture->course->user_id ==  Auth::id()) {
                $quizzes->delete();
                return response()->json([
                    'status' => "quiz has been deleted"
                ]);
            } else {
                abort(403);
            }
        } catch (\Throwable $th) {
            return back();
        }
    }
}
