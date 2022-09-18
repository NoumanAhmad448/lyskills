<?php

namespace App\Http\Requests;

use App\Rules\IsScriptAttack;
use Illuminate\Foundation\Http\FormRequest;

class CreateNotificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'message' => ['required','string',new IsScriptAttack]
        ];
    }

    public function messages()
    {
        return [
            'message.required' => 'Please provide the required message for your instructors',
            'message.string' => 'Your message must be only english alphebets',
        ];
    }
}
