<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Course;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CourseVideoRequest extends FormRequest
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
            'course_vid'  => 'mimetypes:video/mp4,video/webm,video/ogg | max:4500000'
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
            'course_vid.mimes' => 'Allowed video types are mp4,webm, and ogg',
            'course_vid.max' => 'Max File size is allowed upto 4GB',
        ];
    }


    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json(['course_vid' => $validator->errors()], 422));
    }

}
