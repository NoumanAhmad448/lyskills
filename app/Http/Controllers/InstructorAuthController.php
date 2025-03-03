<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Classes\LyskillsCarbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Exception;

class InstructorAuthController extends Controller
{
    public function __construct()
    {
        // Add middleware to check if user is already logged in
        // $this->middleware('guest')->except('logout');
    }

    public function showRegister()
    {
        try {
            // Additional check in case middleware fails
            if (Auth::check()) {
                return redirect()->route('dashboard');
            }

            return view('auth.instructor.register', [
                'title' => __('instructor.auth.register_title'),
                'desc' => __('instructor.auth.register_desc')
            ]);
        } catch (Exception $e) {
            if(config("app.debug")){
                dd($e->getMessage());
            }else{
                return back()->with('error', __("messages.universal_err_msg"));
            }
        }
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'expertise' => ['required', 'string', 'max:255'],
                'teaching_experience' => ['required', 'integer', 'min:0'],
                'qualification' => ['required', 'string', 'max:255'],
                'g-recaptcha-response' => 'required|captcha',

            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_instructor' => 1,
                'expertise' => $request->expertise,
                'teaching_experience' => $request->teaching_experience,
                'qualification' => $request->qualification,
                'email_verified_at' => LyskillsCarbon::now()

            ]);

            Auth::login($user);

            return redirect()->route('dashboard')
                ->with('status', __('instructor.auth.registration_success'));

        } catch (Exception $e) {
            if(config("app.debug")){
                dd($e->getMessage());
            }else{
                return back()->with('error', __("messages.universal_err_msg"));
            }
        }
    }

    public function showLogin()
    {
        try {
            // Additional check in case middleware fails
            if (Auth::check()) {
                return redirect()->route('dashboard');
            }

            return view('auth.instructor.login', [
                'title' => __('instructor.auth.login_title'),
                'desc' => __('instructor.auth.login_desc')
            ]);
        } catch (Exception $e) {
            if(config("app.debug")){
                dd($e->getMessage());
            }else{
                return back()->with('error', __("messages.universal_err_msg"));
            }
        }
    }

    public function login(Request $request)
    {
        try {
           $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
                'g-recaptcha-response' => 'required|captcha',
            ]);

            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required']
            ]);

            $user = User::where('email', $request->email)
                       ->where('is_instructor', 1)
                       ->first();

            if (!$user) {
                return back()->withErrors([
                    'email' => __('instructor.auth.invalid_instructor'),
                ]);
            }

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route('dashboard');
            }

            return back()->withErrors([
                'email' => __('instructor.auth.invalid_credentials'),
            ]);

        } catch (Exception $e) {
            if(config("app.debug")){
                dd($e->getMessage());
            }else{
                return back()->with('error', __("messages.universal_err_msg"));
            }
        }
    }
} 