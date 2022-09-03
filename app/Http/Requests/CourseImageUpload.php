<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Course;
class CourseImageUpload extends FormRequest
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
            'course_img' => 'image|mimes:jpeg,png,jpg,gif,tif|max:10000'
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
            'course_img.image' => 'File must be Image',
            'course_img.mimes' => 'File must be among jpeg,png,jpg,gif,tif type',
            'course_img.max' => 'Max Size allowed is 10MB',

        ];
    }

}
