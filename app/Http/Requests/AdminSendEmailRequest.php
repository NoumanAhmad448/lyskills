<?php

namespace App\Http\Requests;

use App\Rules\IsScriptAttack;
use Illuminate\Foundation\Http\FormRequest;

class AdminSendEmailRequest extends FormRequest
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
            'status' => 'required',
            'subject' => ['required','string', new IsScriptAttack],
            'body' =>['required','string' ]
        ];
    }
}
