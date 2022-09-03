<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Promotion;

class CouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $promotion = Promotion::find($this->route('promotion'));

        return $promotion && $this->user()->id == $promotion->course->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'coupon_no' => 'required|max:255',
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
            'coupon_no.required' => 'Coupon code is required',
            'coupon_no.max' => 'Your Coupon digits should not greater than 255',
        ];
    }
}
