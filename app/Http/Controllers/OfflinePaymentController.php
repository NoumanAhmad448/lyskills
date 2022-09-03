<?php

namespace App\Http\Controllers;

use App\Models\OfflinePayment;
use App\Rules\IsScriptAttack;
use App\Rules\ValidPhoneNumber;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class OfflinePaymentController extends Controller
{
    public function paymentGateways()
    { 

    try{

        $title = 'offline_payment';
        $offline = OfflinePayment::first();        
        return view("admin.offline_payment",compact('title','offline'));
    }
        catch(Exception $e){
            return back()->with('error', 'this action cannot be performed now');
        }
    }

    public function storeJazzPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'j_form' => 'nullable',
            'j_mobile_no' => ['required','numeric',new IsScriptAttack, new ValidPhoneNumber],
            'j_account_name' => ['required','string',new IsScriptAttack],            
            'j_note' => ['required','string',new IsScriptAttack],            
        ],[],['j_mobile_no' => 'mobile', 'j_account_name' => 'Account Name', 'j_note' => 'jazzcash note']);

        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();        
        }

        try{
            $setting = OfflinePayment::first();
            if(!$setting){
                $setting = new OfflinePayment;
            }
            $setting->j_is_enable = $request->j_form ? 1 : 0;
            $setting->j_mobile_number = $request->j_mobile_no;
            $setting->j_account_name = $request->j_account_name;            
            $setting->j_note = $request->j_note;            
            $setting->save();
        }
        catch(Exception $e){
            return back()->with('error', 'Server Error');
        }

        return back()->with('status', 'saved');

    }

    public function storeEasypaisaPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'easypaisa___form' => 'nullable',
            'e_mobile_number' => ['required','numeric', new IsScriptAttack, new ValidPhoneNumber],
            'e_account_name' => ['required','string', new IsScriptAttack],            
            'e_note' => ['required','string', new IsScriptAttack],            
        ],[],['e_mobile_number' => 'Easypaisa mobile number', 'e_account_name' => 'Account Name']);

        if ($validator->fails()) {
            return  redirect()->route('a_offline_payment_gateways',['#easypaisa_form'])
                    ->withErrors($validator)
                    ->withInput();        
        }

        try{
            $setting = OfflinePayment::first();
            if(!$setting){
                $setting = new OfflinePayment();
            }
            $setting->e_is_enable = $request->easypaisa___form ? 1 : 0;
            $setting->e_mobile_number = $request->e_mobile_number;
            $setting->e_account_name = $request->e_account_name;            
            $setting->e_note = $request->e_note;            
            $setting->save();
        }
        catch(Exception $e){
            return redirect()->route('a_offline_payment_gateways',['#easypaisa_form'])->with('error', 'Server Error');
        }

        return redirect()->route('a_offline_payment_gateways',['#easypaisa_form'])->with('status', 'saved');
    }
    public function storeOtherPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'other_form' => 'nullable',
            'o_mobile' => ['required','numeric', new IsScriptAttack, new ValidPhoneNumber],            
            'o_note' => ['required','string', new IsScriptAttack],            
        ],[],['o_mobile' => 'mobile number', 'o_note' => 'note']);

        if ($validator->fails()) {
            return  redirect()->route('a_offline_payment_gateways',['#other-form'])
                    ->withErrors($validator)
                    ->withInput();        
        }

        try{
            $setting = OfflinePayment::first();
            if(!$setting){
                $setting = new OfflinePayment();
            }
            $setting->o_is_enable = $request->other_form ? 1 : 0;
            $setting->o_mobile_number = $request->o_mobile;            
            $setting->o_note = $request->o_note;            
            $setting->save();
        }
        catch(Exception $e){
            return redirect()->route('a_offline_payment_gateways',['#other-form'])->with('error', 'Server Error');
        }

        return redirect()->route('a_offline_payment_gateways',['#other-form'])->with('status', 'saved');
    }


    public function storeBankPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'b_is_enable' => 'nullable',
            'b_bank_name' => ['required','string', new IsScriptAttack],            
            'b_swift_code' => ['required','string', new IsScriptAttack],            
            'b_account_name' => ['required','string', new IsScriptAttack],            
            'b_account_number' => ['required','string', new IsScriptAttack],            
            'b_branch_name' => ['required','string', new IsScriptAttack],            
            'b_branch_address' => ['required','string', new IsScriptAttack],            
            'b_iban' => ['required','string', new IsScriptAttack],            
            'b_note' => ['required','string', new IsScriptAttack],            
        ],[],['b_bank_name' => 'bank name', 'b_swift_code' => 'swift code'
                    , 'b_account_name' => 'account name', 
                    'b_account_number' => 'Account number',
                    'b_branch_name' => 'branch name',
                    'b_branch_address' => 'branch address',
                    'b_iban' => 'IBAN',
                    'b_note' => 'note',

        ]);


        
        if ($validator->fails()) {
            return  redirect()->route('a_offline_payment_gateways',['#bank-form'])
                    ->withErrors($validator)
                    ->withInput();        
        }

        try{
            $setting = OfflinePayment::first();
            if(!$setting){
                $setting = new OfflinePayment();
            }
            $setting->b_is_enable = isset($request->b_is_enable) ? 1 : 0;
            $setting->b_bank_name = $request->b_bank_name;            
            $setting->b_swift_code = $request->b_swift_code;            
            $setting->b_account_name = $request->b_account_name;            
            $setting->b_account_number = $request->b_account_number;            
            $setting->b_branch_name = $request->b_branch_name;            
            $setting->b_branch_address = $request->b_branch_address;            
            $setting->b_iban = $request->b_iban;            
            $setting->b_note = $request->b_note;            
            $setting->save();
        }
        catch(Exception $e){
            return redirect()->route('a_offline_payment_gateways',['#bank-form'])->with('error', 'Server Error'.$e->getMessage());
        }

        return redirect()->route('a_offline_payment_gateways',['#bank-form'])->with('status', 'saved');
    }
    
}
