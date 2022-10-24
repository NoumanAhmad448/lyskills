<?php

return [

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
