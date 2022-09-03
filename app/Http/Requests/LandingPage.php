<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Course;
class LandingPage extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $course = Course::findOrFail($this->route('course'));

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
            'course_title' => 'required|max:1000',
            'course_desc' => 'required|max:1500|min:700',
            'select_level' => 'required',
            'select_category' => 'required',
            'lang' => 'required',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
{
    return [
        'course_title' => 'course title',
        'course_desc' => 'course description',
        'select_level' => 'Course Level',
        'select_category' => 'Course Category',
        'lang' => 'Language',
    ];
}
}
