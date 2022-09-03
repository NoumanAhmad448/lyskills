<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserReq extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'student' => 'nullable',
            'instructor' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please provide user name',
            'name.max' => 'User name must not increase from 255 characters',
            'email.required' => 'Have you typed the email?',
            'email.email' => 'Please provide the valid email address',
        ];
    }
}
