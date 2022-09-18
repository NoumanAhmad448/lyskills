<?php

namespace App\Http\Requests;

use App\Rules\IsScriptAttack;
use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            'email' => ['required',new IsScriptAttack],
            'password' => ['required', new IsScriptAttack],
            'g-recaptcha-response' => 'required|captcha',

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
            'email.required' => 'Please write your username',
            'password.required' => 'Please type your password',
        ];
    }

    public function attributes()
    {
        return [
            'g-recaptcha-response' => 'captcha'
        ];
    }
}
