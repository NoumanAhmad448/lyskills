<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryValidation extends FormRequest
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
            'name' => 'required|max:255|unique:sub_categories',            
            'sub_c' => 'required',            
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Category Name',
            'sub_c' => 'Category',
        ];
    }
}
