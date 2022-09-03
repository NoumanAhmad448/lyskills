<?php

namespace App\Http\Requests;
use App\Models\QuizQuestionAns;

use Illuminate\Foundation\Http\FormRequest;

class QuizQuestionPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $quiz = QuizQuestionAns::find($this->route('quizzes'));

        return $quiz && $quiz->quiz->lecture->course->user_id == $this->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'question' => 'bail|required|max:1000',
            'ans1' => 'bail|required|max:1000',
            'ans2' => 'bail|required|max:1000',
            'ans3' => 'bail|required|max:1000',
            'ans4' => 'bail|required|max:1000',
            'reason_ans' => 'bail|nullable|max:1000',
            'ans'=> 'bail|required|in:a1,a2,a3,a4'


            
        ];
    }

    public function messages()
    {
        return [
            'question.required' => 'You did not write your question',
            'question.max' => 'Question should not exceed the 1000 length characters',
            'ans1.required' => 'You did not provide your first option',
            'ans1.max' => 'First option should not exceed the 1000 length characters',
            'ans2.required' => 'You did not provide your second option',
            'ans2.max' => 'Option 2 should not exceed the 1000 length characters',
            'ans3.required' => 'You did not provide your third option',
            'ans3.max' => 'Option 3 should not exceed the 1000 length characters',
            'ans4.required' => 'You did not provide your forth option',
            'ans4.max' => 'Option 4 should not exceed the 1000 length characters',
            'ans.required' => 'You must choose one :attribute',
        ];
    }

    public function attributes()
    {
        return [
            'ans' => 'Answer',
        ];
    }
}
