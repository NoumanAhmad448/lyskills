<?php
namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EasypaisaController extends Controller
{
    public function getPayment()
    {
        try {
            $response =  Http::get('https://openexchangerates.org/api/latest.json?app_id=bbaa84cbf0c34ad6804979bbaec7a47a');
            if ($response->ok()) {
                $pkr_currency = (int)$response['rates']['PKR'];
                dd($pkr_currency);
            }

            return back()->with('error', 'something went wrong');
        } catch (\Throwable $th) {
            return back()->with('error', 'something went wrong');
        }
    }


    public function getEasypay()
    {
        $timestamp = strtotime(date("h:i:sa")) + 2*60*60;
        $time = date('Y-m-d h:i:s', $timestamp);        
        // dd($time);
        $timestamp = date('Y-m-d h:i:s', strtotime(date("h:i:sa")));
        // dd($timestamp);
        return view('easypaisa.send-request-easypaisa',compact('time'));

        $url = 'https://easypay.easypaisa.com.pk/easypay/Index.jsf';
        $data = [
            'amount' => 20,
            'storeId' => 63628,
            'postBackURL' => route('get-token-pay'),
            'orderRefNum' => rand(10, 10000),
            'autoRedirect' => 1
        ];

        $fields = [
            $data,
            'btnSubmit'         => 'Submit'
        ];

        $fields_string = http_build_query($fields);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        echo $result;
    }

    public function getEasypayToken(Request $request)
    {
        dd($request->all());
    }
    
    
    public function getHashKeyEn(Request $request)
    {
        try{
            $sampleString = $request->str;
            $c_d_t = date("Y-m-d").'T'.date("h:i:s");
            $sampleString .= $c_d_t;
            $hashKey = 'HHRGU5NT3RPVHV2L';
            $cipher = "aes-128-ecb";
            $crypttext = openssl_encrypt($sampleString, $cipher, $hashKey,OPENSSL_RAW_DATA);
            $hashRequest = base64_encode($crypttext);
            
            return response()->json(['param' => $hashRequest, 't' => $c_d_t]);
        }
        
        catch(\Throwable $e){
            echo "something went wrong";
        }
    }
    
    
        public function getJazz(){
           return view('jaxxcash/jaxxcash');
        }
        
        
        public function jazzcashCallBack(Request $request){
            dd($request->all())   ;
        }



    
    
}
