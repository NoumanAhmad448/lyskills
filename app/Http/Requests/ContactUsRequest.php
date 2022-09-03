<?php

namespace App\Http\Requests;

use App\Rules\IsScriptAttack;
use App\Rules\ValidPhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class ContactUsRequest extends FormRequest
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
            'name' => ['required','string',new IsScriptAttack],
            'email' => ['required','email',new IsScriptAttack],
            'mobile' => ['nullable','numeric',new ValidPhoneNumber, new IsScriptAttack],
            'country' => ['nullable','string', new IsScriptAttack],
            'subject' => ['required','string', new IsScriptAttack],
            'body' => ['required','string', new IsScriptAttack],
            'g-recaptcha-response' => 'required|captcha'
        ];
    }
}
