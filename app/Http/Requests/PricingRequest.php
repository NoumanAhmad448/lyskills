<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Course;

class PricingRequest extends FormRequest
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
            'pricing' => 'nullable|numeric|min:1|max:500',
            'free' => 'nullable',

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
            'pricing.required' => 'Please provide the course price',
            'pricing.numeric' => 'Price must be in digit',
            'pricing.min' => 'You must provide atleast 1 dollar',
            'pricing.max' => 'Price must be less than 500 dollar',
        ];
    }


}
