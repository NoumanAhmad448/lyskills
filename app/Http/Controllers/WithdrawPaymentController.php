<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WithdrawPayment;
use App\Rules\IsScriptAttack;
use Exception;
use Illuminate\Support\Facades\Validator;

class WithdrawPaymentController extends Controller
{

    public function show()
    {
        try {
            $title = 'withdraw_rules';
            $withdraw = WithdrawPayment::first();
            return view("admin.a_w_p_c", compact('title', 'withdraw'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function storeJazzPayment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'j_min' => ['required', 'numeric', new IsScriptAttack],
                'j_note' => ['required', 'string', new IsScriptAttack],
            ], [], ['j_min' => 'minimum amount', 'j_note' => 'note']);

            if ($validator->fails()) {
                return  redirect()->route('a_w_p_c', ['#jazzcash_form'])
                    ->withErrors($validator)
                    ->withInput();
            }
        } catch (\Throwable $th) {
            return back();
        }

        try {
            $setting = WithdrawPayment::first();
            if (!$setting) {
                $setting = new WithdrawPayment;
            }
            $setting->j_min = $request->j_min ?? null;
            $setting->j_note = $request->j_note ?? null;
            $setting->save();
        } catch (Exception $e) {
            return  redirect()->route('a_w_p_c', ['#jazzcash_form'])
                ->with('error', 'Server Error');
        }

        return  redirect()->route('a_w_p_c', ['#jazzcash_form'])
            ->with('status', 'saved');
    }

    public function storePaypalPayment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'p_min' => ['required', 'numeric', new IsScriptAttack],
                'p_note' => ['required', 'string', new IsScriptAttack],
            ], [], ['p_min' => 'min amount', 'p_note' => 'note']);

            if ($validator->fails()) {
                return  redirect()->route('a_w_p_c', ['#paypal-form'])
                    ->withErrors($validator)
                    ->withInput();
            }
        } catch (\Throwable $th) {
            return back();
        }

        try {
            $setting = WithdrawPayment::first();
            if (!$setting) {
                $setting = new WithdrawPayment();
            }
            $setting->p_min = $request->p_min ?? null;
            $setting->p_note = $request->p_note ?? null;
            $setting->save();
        } catch (Exception $e) {
            return redirect()->route('a_w_p_c', ['#paypal-form'])->with('error', 'Server Error');
        }

        return redirect()->route('a_w_p_c', ['#paypal-form'])->with('status', 'saved');
    }
    public function storeEasypaisaPayment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'e_min' => ['required', 'numeric', new IsScriptAttack],
                'e_note' => ['required', 'string', new IsScriptAttack],
            ], [], ['e_min' => 'min amount', 'e_note' => 'note']);

            if ($validator->fails()) {
                return  redirect()->route('a_w_p_c', ['#easypaisa_form'])
                    ->withErrors($validator)
                    ->withInput();
            }
        } catch (\Throwable $th) {
            return back();
        }

        try {
            $setting = WithdrawPayment::first();
            if (!$setting) {
                $setting = new WithdrawPayment();
            }
            $setting->e_min = $request->e_min ?? null;
            $setting->e_note = $request->e_note ?? null;
            $setting->save();
        } catch (Exception $e) {
            return redirect()->route('a_w_p_c', ['#easypaisa_form'])->with('error', 'Server Error');
        }

        return redirect()->route('a_w_p_c', ['#easypaisa_form'])->with('status', 'saved');
    }

    public function storeBankPayment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'b_min' => ['required', 'numeric', new IsScriptAttack],
                'b_note' => ['required', 'string', new IsScriptAttack],
            ], [], ['b_min' => 'min amount', 'b_note' => 'note']);

            if ($validator->fails()) {
                return  back()
                    ->withErrors($validator)
                    ->withInput();
            }
        } catch (\Throwable $th) {
            return back();
        }

        try {
            $setting = WithdrawPayment::first();
            if (!$setting) {
                $setting = new WithdrawPayment();
            }
            $setting->b_min = $request->b_min ?? null;
            $setting->b_note = $request->b_note ?? null;
            $setting->save();
        } catch (Exception $e) {
            return back()->with('error', 'Server Error' . $e);
        }

        return back()->with('status', 'saved');
    }
}
