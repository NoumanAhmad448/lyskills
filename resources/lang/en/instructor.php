<?php

return [
    'auth' => [
        'register_title' => 'Instructor Registration',
        'register_desc' => 'Join our teaching community',
        'login_title' => 'Instructor Login',
        'login_desc' => 'Access your teaching dashboard',
        'registration_success' => 'Successfully registered as an instructor!',
        'invalid_instructor' => 'This email is not registered as an instructor',
        'invalid_credentials' => 'The provided credentials are incorrect',
        'remember_me' => 'Remember Me',
        'login_button' => 'Login',
        'register_link' => 'Need an account? Register',
        'forgot_password' => 'Forgot Your Password?',
        'Login_link' => 'Already have an account? Login'
    ],
    'fields' => [
        'name' => 'Full Name',
        'email' => 'Email Address',
        'password' => 'Password',
        'password_confirmation' => 'Confirm Password',
        'expertise' => 'Area of Expertise',
        'teaching_experience' => 'Years of Teaching Experience',
        'qualification' => 'Highest Qualification'
    ],
    'validation' => [
        'required' => 'The :attribute field is required',
        'email' => 'Please enter a valid email address',
        'min' => [
            'string' => 'The :attribute must be at least :min characters',
            'integer' => 'The :attribute must be at least :min'
        ],
        'unique' => 'This email is already registered'
    ]
]; 