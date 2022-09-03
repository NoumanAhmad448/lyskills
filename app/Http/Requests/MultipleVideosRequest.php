<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Course;

class MultipleVideosRequest extends FormRequest
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
            'upload_b_vid.*' => 'required|file|max:4000000|mimetypes:video/mp4,video/webm,video/ogg'
        ];
    }
}
