<?php

namespace App\Http\Controllers;

use App\Models\Social;
use App\Models\User;
use App\Rules\IsScriptAttack;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class SocialController extends Controller
{
    public function show()
    {
        try {
            $title = 'social_rules';
            $social = Social::first();
            return view("admin.social_accounts_setting", compact('title', 'social'));
        } catch (\Throwable $th) {
            return back();
        }
    }


    public function facebook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'enable' => ['nullable'],
            'fb_app_key' => ['required', 'string', new IsScriptAttack],
            'fb_secret_key' => ['required', 'string', new IsScriptAttack],
        ], [], ['fb_app_key' => 'App key', 'fb_secret_key' => 'Secret Key']);


        if ($validator->fails()) {
            return  redirect()->route('social_networks')
                ->withErrors($validator)
                ->withInput();
        }


        try {
            $setting = Social::first();
            if (!$setting) {
                $setting = new Social();
            }
            $setting->f_enable = isset($request->enable) ? 1 : 0;
            $setting->f_app_id = $request->fb_app_key ?? null;
            $setting->f_security_key = $request->fb_secret_key ?? null;
            $setting->save();
        } catch (Exception $e) {
            return  redirect()->route('social_networks')
                ->with('error', 'Server Error');
        }

        return  redirect()->route('social_networks')
            ->with('status', 'saved');
    }


    public function google(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'enable_g' => ['nullable'],
            'g_app_key' => ['required', 'string', new IsScriptAttack],
            'g_secret_key' => ['required', 'string', new IsScriptAttack],
        ], [], ['g_app_key' => 'App key', 'g_secret_key' => 'Secret Key']);

        if ($validator->fails()) {
            return  redirect()->route('social_networks', ['#google-form'])
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $setting = Social::first();
            if (!$setting) {
                $setting = new Social();
            }
            $setting->g_enable = isset($request->enable_g) ? 1 : 0;
            $setting->g_app_id = $request->g_app_key ?? null;
            $setting->g_security_key = $request->g_secret_key ?? null;
            $setting->save();
        } catch (Exception $e) {
            return  redirect()->route('social_networks', ['#google-form'])
                ->with('error', 'Server Error');
        }

        return  redirect()->route('social_networks', ['#google-form'])
            ->with('status', 'saved');
    }


    public function linkedin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'enable_l' => ['nullable'],
            'l_app_key' => ['required', 'string', new IsScriptAttack],
            'l_secret_key' => ['required', 'string', new IsScriptAttack],
        ], [], ['l_app_key' => 'App key', 'l_secret_key' => 'Secret Key']);

        if ($validator->fails()) {
            return  redirect()->route('social_networks', ['#linkedin_form'])
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $setting = Social::first();
            if (!$setting) {
                $setting = new Social();
            }
            $setting->l_enable = isset($request->enable_l) ? 1 : 0;
            $setting->l_app_id = $request->l_app_key ?? null;
            $setting->l_security_key = $request->l_secret_key ?? null;
            $setting->save();
        } catch (Exception $e) {
            return  redirect()->route('social_networks', ['#linkedin_form'])
                ->with('error', 'Server Error');
        }

        return  redirect()->route('social_networks', ['#linkedin_form'])
            ->with('status', 'saved');
    }

    public function googleVerification()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleLogin(Request $request)
    {
        try {
            $user = Socialite::driver('google')->user();
            // name 
            // id 
            // email 
            // profile photo path
            // dd($user);
            $id = $user->id ?? null;
            if (!$id) {
                return redirect()->route('register')->with('error', 'Google server error. please try again');
            }
            $u = User::where('social_id', $id)->first();
            if ($u) {
                $request->session()->regenerate();
                Auth::login($u);
                return redirect()->intended('/');
            }
            $u_email_based = User::where('email', $user->email)->first();
            if ($u_email_based) {
                $request->session()->regenerate();
                Auth::login($u_email_based);
                return redirect()->intended('/');
            }
            if (!$u) {
                $e = $user->email ?? null;
                if (!$e) {
                    return redirect()->route('register')->with('error', 'google server email error. please try again');
                }

                $new_user = new User;
                $u_name = $user->name ?? null;
                if (!$u_name) {
                    return redirect()->route('register')->with('error', 'google server name error. please try again');
                }
                $new_user->name = $u_name;
                $new_user->social_id = $id;

                $new_user->email = $e;

                $new_user->email_verified_at = now();
                $new_user->save();

                $request->session()->regenerate();
                Auth::login($new_user);
                return redirect()->intended('/');
            }
        } catch (\Throwable $th) {
            return back();
        }
    }
    public function facebookVerification()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookLogin(Request $request)
    {
        try {
            $user = Socialite::driver('facebook')->user();
            // name 
            // id 
            // email 
            // profile photo path
            // dd($user);
            $id = $user->id ?? null;
            if (!$id) {
                return redirect()->route('register')->with('error', 'facebook server error. please try again');
            }
            $u = User::where('social_id', $id)->first();
            if ($u) {
                $request->session()->regenerate();
                Auth::login($u);
                return redirect()->intended('/');
            }
            $u_email_based = User::where('email', $user->email)->first();
            if ($u_email_based) {
                $request->session()->regenerate();
                Auth::login($u_email_based);
                return redirect()->intended('/');
            }
            if (!$u) {
                $e = $user->email ?? null;
                if (!$e) {
                    return redirect()->route('register')->with('error', 'facebook server email error. please try again');
                }

                $new_user = new User;
                $u_name = $user->name ?? null;
                if (!$u_name) {
                    return redirect()->route('register')->with('error', 'facebook server name error. please try again');
                }
                $new_user->name = $u_name;
                $new_user->social_id = $id;

                $new_user->email = $e;

                $new_user->email_verified_at = now();
                $new_user->save();

                $request->session()->regenerate();
                Auth::login($new_user);
                return redirect()->intended('/');
            }
        } catch (\Throwable $th) {
            return back();
        }
    }
    public function linkedinVerification()
    {
        return Socialite::driver('linkedin')->redirect();
    }

    public function linkedinLogin(Request $request)
    {
        try {
            $user = Socialite::driver('linkedin')->user();
            // name 
            // id 
            // email 
            // profile photo path
            // dd($user);
            $id = $user->id ?? null;
            if (!$id) {
                return redirect()->route('register')->with('error', 'facebook server error. please try again');
            }
            $u = User::where('social_id', $id)->first();
            if ($u) {
                $request->session()->regenerate();
                Auth::login($u);
                return redirect()->intended('/');
            }
            $u_email_based = User::where('email', $user->email)->first();
            if ($u_email_based) {
                $request->session()->regenerate();
                Auth::login($u_email_based);
                return redirect()->intended('/');
            }
            if (!$u) {
                $e = $user->email ?? null;
                if (!$e) {
                    return redirect()->route('register')->with('error', 'facebook server email error. please try again');
                }

                $new_user = new User;
                $u_name = $user->name ?? null;
                if (!$u_name) {
                    return redirect()->route('register')->with('error', 'facebook server name error. please try again');
                }
                $new_user->name = $u_name;
                $new_user->social_id = $id;

                $new_user->email = $e;

                $new_user->email_verified_at = now();
                $new_user->save();

                $request->session()->regenerate();
                Auth::login($new_user);
                return redirect()->intended('/');
            }
        } catch (\Throwable $th) {
            return back();
        }
    }
}
