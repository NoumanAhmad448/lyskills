<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Course;

class SayonaraRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $course = Course::find($this->route('course'));

        return $course && $this->user()->id == $course->user_id;   
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'wel_msg' => 'bail|required|max:1000',
            'congo_msg' => 'required|max:1000',
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'wel_msg.required' => 'Please write Welcome Message',
            'wel_msg.max' => 'Message cannot exceed 1000 words',
            'congo_msg.required' => 'Please write Congtratulation Message',
            'congo_msg.max' => 'Message must not exceed 1000 words',
        ];
    }
}
