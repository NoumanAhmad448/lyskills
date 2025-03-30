<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Email;


class RuleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extendImplicit('email', function ($attribute, $value, $parameters, $validator) {
            // Use Laravel's original email rule
            $defaultValidation = Email::rfc()->passes($attribute, $value);

            if (!$defaultValidation) {
                return false; // If it doesn't pass the original email validation, reject it
            }

            // Allow only trusted domains (e.g., popular public and educational domains)
            $allowedDomains = [
                'gmail.com', 'yahoo.com', 'outlook.com', 'protonmail.com', 'icloud.com',
                'edu.pk', 'harvard.edu', 'stanford.edu', 'mit.edu'
            ];

            $emailDomain = substr(strrchr($value, "@"), 1); // Extract domain part of email
            return in_array($emailDomain, $allowedDomains);
        });

        Validator::replacer('email', function ($message, $attribute, $rule, $parameters) {
            return "The email must be a valid address from a trusted domain.";
        });
    }
}
