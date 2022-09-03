<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'google' => [
        'client_id' => env('GOOGLE_APP_KEY'),
        'client_secret' => env('GOOGLE_SECURITY_KEY'),
        'redirect' => 'https://lyskills.com/google/callback',
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_APP_KEY'),
        'client_secret' => env('FACEBOOK_SECURITY_KEY'),
        'redirect' => 'https://lyskills.com/facebook/callback',
    ],
    'linkedin' => [
        'client_id' => env('LINKEDIN_APP_KEY'),
        'client_secret' => env('LINKEDIN_SECURITY_KEY'),
        'redirect' => 'https://lyskills.com/linkedin/callback',
    ],
];
