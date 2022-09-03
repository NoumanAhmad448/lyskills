<?php

namespace App\Http\Requests;

use App\Rules\IsScriptAttack;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBloggerProfile extends FormRequest
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
            'name' => ['required',new IsScriptAttack],
            'email' => ['required', new IsScriptAttack],
            'password' => ['required',new IsScriptAttack,'min:8']
        ];
    }
}
