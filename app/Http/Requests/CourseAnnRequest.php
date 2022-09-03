<?php

namespace App\Http\Requests;

use App\Rules\IsScriptAttack;
use Illuminate\Foundation\Http\FormRequest;

class CourseAnnRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->is_instructor ? true: false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'courses' => ['required'],
            'subject' =>  ['required','string',new IsScriptAttack],
            'body' => ['required','string','min:15',new IsScriptAttack]
        ];
    }
}
