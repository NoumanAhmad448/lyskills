<?php

namespace App\Http\Controllers;

use App\Http\Requests\BloggerSettingRequest;
use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SetttingController extends Controller
{
    public function general_setting()
    {
        try {
            $title = 'stng';
            return view('admin.setting.g_setting', compact('title'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function lms_setting()
    {
        try {
            $title = 'lms';
            $s =  Setting::first();
            return view('admin.setting.lms_setting', compact('title', 's'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function save_lms_setting(Request $request)
    {
        try {
            if (isAdmin()) {
                $s =  Setting::first();
                if (!$s) {
                    $s = new Setting;
                }

                if ($request->boolean('discussion')) {
                    $s->isDisscussion = 1;
                } else {
                    $s->isDisscussion = 0;
                }
                $s->save();
                return back()->with('status', 'discussion has updated');
            }
        } catch (\Throwable $th) {
            return back();
        }
    }


    public function paymentGateways()
    {
        try {
            $setting = Setting::first();
            $title = 'Payment_gateway';
            return view('admin.payment-gateways', compact('title', 'setting'));
        } catch (Exception $e) {
            return back()->with('error', 'this action cannot be perfored now. please try again');
        }
    }

    public function storeStripPayment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'strip_form' => 'nullable',
                's_s_key' => ['required', 'string'],
                's_p_key' => ['required', 'string'],
            ], [], ['s_s_key' => 'secret key', 's_p_key' => 'publishable key']);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }


            try {
                $setting = Setting::first();
                if (!$setting) {
                    $setting = new Setting;
                }
                $setting->s_is_enable = $request->strip_form ? 1 : 0;
                $setting->s_live_key = $request->s_s_key;
                $setting->s_publish_key = $request->s_p_key;
                $setting->save();
            } catch (Exception $e) {
                return back()->with('error', 'Server Error');
            }

            return back()->with('status', 'saved');
        } catch (\Throwable $th) {
            return back();
        }
    }
    public function storePaypalPayment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'paypal_form' => 'nullable',
                'p_s_key' => ['required', 'string'],
                'p_p_key' => ['required', 'string'],
                'paypal_email' => ['required', 'email'],
            ], [], ['p_s_key' => 'secret key', 'p_p_key' => 'publishable key', 'paypal_email' => "Paypal Email"]);

            if ($validator->fails()) {
                return redirect()->route('a_payment_gateways', ['#paypal-form'])
                    ->withErrors($validator)
                    ->withInput();
            }

            try {
                $setting = Setting::first();
                if (!$setting) {
                    $setting = new Setting;
                }
                $setting->paypal_is_enable = $request->paypal_form ? 1 : 0;
                $setting->p_live_key = $request->p_s_key;
                $setting->p_publish_key = $request->p_p_key;
                $setting->paypal_email = $request->paypal_email;
                $setting->save();
            } catch (Exception $e) {
                return redirect()->route('a_payment_gateways', ['#paypal-form'])->with('error', 'Server Error');
            }

            return redirect()->route('a_payment_gateways', ['#paypal-form'])->with('status', 'saved');
        } catch (\Throwable $th) {
            return back();
        }
    }
    public function storeJazzPayment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'jazzcash_form' => 'nullable',
                'j_s_key' => ['required', 'string'],
                'j_p_key' => ['required', 'string'],
            ], [], ['j_s_key' => 'secret key', 'j_p_key' => 'publishable key']);

            if ($validator->fails()) {
                return redirect()->route('a_payment_gateways', ['#jazzcash__form'])
                    ->withErrors($validator)
                    ->withInput();
            }

            try {
                $setting = Setting::first();
                if (!$setting) {
                    $setting = new Setting;
                }
                $setting->j_is_enable = $request->jazzcash_form ? 1 : 0;
                $setting->j_live_key = $request->j_s_key;
                $setting->j_publish_key = $request->j_p_key;
                $setting->save();
            } catch (Exception $e) {
                return redirect()->route('a_payment_gateways', ['#jazzcash__form'])->with('error', 'Server Error');
            }

            return redirect()->route('a_payment_gateways', ['#jazzcash__form'])->with('status', 'saved');
        } catch (\Throwable $th) {
            return back();
        }
    }
    public function storeEasypaisaPayment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'easypaisa___form' => 'nullable',
                'e_s_key' => ['required', 'string'],
                'e_p_key' => ['required', 'string'],
            ], [], ['e_s_key' => 'secret key', 'e_p_key' => 'publishable key']);

            if ($validator->fails()) {
                return  redirect()->route('a_payment_gateways', ['#easypaisa_form'])
                    ->withErrors($validator)
                    ->withInput();
            }

            try {
                $setting = Setting::first();
                if (!$setting) {
                    $setting = new Setting;
                }
                $setting->e_is_enable = $request->easypaisa___form ? 1 : 0;
                $setting->e_live_key = $request->e_s_key;
                $setting->e_publish_key = $request->e_p_key;
                $setting->save();
            } catch (Exception $e) {
                return redirect()->route('a_payment_gateways', ['#easypaisa_form'])->with('error', 'Server Error');
            }

            return redirect()->route('a_payment_gateways', ['#easypaisa_form'])->with('status', 'saved');
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function blog()
    {
        try {
            $title = 'lms';
            $s =  Setting::select('isBlog', 'isFaq')->first();
            return view('admin.setting.bloggers_setting', compact('title', 's'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function blogPost(Request $request)
    {

        try {
            $s =  Setting::first();
            if (!$s) {
                $s = new Setting;
            }


            if ($request->boolean('blog_e_d')) {
                $s->isBlog = 1;
            } else {
                $s->isBlog = 0;
            }


            if ($request->boolean('faq')) {
                $s->isFaq = 1;
            } else {

                $s->isFaq = 0;
            }

            $s->save();
            return back()->with('status', 'updated');
        } catch (\Throwable $th) {
            return back();
        }
    }
}
