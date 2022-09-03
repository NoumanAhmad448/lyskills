<?php

namespace App\Rules;

use App\Models\Faq;
use Illuminate\Contracts\Validation\Rule;

class FaqDuplicateTitle implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !(Faq::where('title',$value)->first());   
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute must not be same which means you have already created this :attribute';
    }
}
