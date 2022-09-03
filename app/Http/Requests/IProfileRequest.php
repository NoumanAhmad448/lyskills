<?php

namespace App\Http\Requests;

use App\Rules\IsScriptAttack;
use Illuminate\Foundation\Http\FormRequest;

class IProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required','string', new IsScriptAttack],
            'headline' => ['required','string','max:40', new IsScriptAttack],
            'bio' => ['required','string',new IsScriptAttack],
            'website' => 'nullable|url',
            'twitter' => 'nullable|url',
            'facebook' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'youtube' => 'nullable|url',
        ];
    }


    public function messages()
{
    return [
        'headline.required' => 'Professional title must be provided',
        'headline.max' => 'Total number of headline characters must not exceed :attribute',
        'website.url' => 'Please provide the :attribute link',
        'twitter.url' => 'Please provide the :attribute link',
        'facebook.url' => 'Please provide the :attribute link',
        'twitter.url' => 'Please provide the :attribute link',
        'youtube.url' => 'Please provide the :attribute link',
        'linkedin.url' => 'Please provide the :attribute link',
    ];
}
}
