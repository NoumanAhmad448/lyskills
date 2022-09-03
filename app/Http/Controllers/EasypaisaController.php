<?php
namespace App\Http\Controllers;

use App\Mail\InformInstructorMail;
use App\Mail\StudentEnrollmentMail;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\CourseHistory;
use App\Models\InstructorEarning;
use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class EasypaisaController extends Controller
{
    public function getPayment()
    {
        try {
            $response =  Http::get('https://openexchangerates.org/api/latest.json?app_id=bbaa84cbf0c34ad6804979bbaec7a47a');
            if ($response->ok()) {
                $pkr_currency = $response['rates']['PKR'];
                return $pkr_currency;
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

    public function getEasypayToken()
    {
        // try {
            if(!isset($_GET['slug'])){
                abort(403);
            }
            $course = Course::where('slug', $_GET['slug'])->first();
            if(!$course){
                abort(403);


            }
            // dd($course);
            $c_id = $course->id;
            $u_id = auth()->id();
            $price_in_do = (int)$course->price->pricing;
                CourseEnrollment::create(['course_id' => $c_id, 'user_id' => $u_id]);
                CourseHistory::create(['course_id' => $c_id, 'user_id' => $u_id, 'pay_method' => 'Easypaisa',
                'amount' => $price_in_do, 'ins_id' => $course->user->id]);
                
                $policy = Setting::select('payment_share_enable', 'instructor_share')->first();
                if ($policy->count() && $policy->payment_share_enable) {
                    $earning = ((int) $policy->instructor_share * (int) $price_in_do) / 100;
                    InstructorEarning::create(['course_id' => $c_id, 'user_id' => $u_id, 'earning' => $earning, 'ins_id' => $course->user->id]);
                    
                } else {
                    $earning = (50 * (int) $price_in_do) / 100;
                    InstructorEarning::create(['course_id' => $c_id, 'user_id' => $u_id, 'earning' => $earning, 'ins_id' => $course->user->id]);
                }

                setEmailConfigForCourse();
                $course_url = route('user-course', $course->slug);
                
                Mail::to(auth()->user()->email)->queue(new StudentEnrollmentMail(auth()->user()->name, $course->course_title, $course_url));
                Mail::to($course->user->email)->queue(new InformInstructorMail(auth()->user()->name, $course->course_title, $course_url, $course->user->name));
                

                return redirect()->route('user-course', ['slug' => $course->slug])->with('status','congtratulation! you are enrolled now. please click start button and start watching the course');
        // } catch (\Throwable $th) {
        //     dd($th->getMessage());
        // }
    }
    
    
    public function getHashKeyEn(Request $request)
    {
        try{
            $sampleString = $request->str;
            $c_d_t = date("Y-m-d").'T'.date("h:i:s");
            // $sampleString['postBackURL'] = route('get-token-pay');
            $sampleString .= $c_d_t;
            // $sampleString = http_build_query ($sampleString);
            
            // $sampleString = json_encode($sampleString);
            // echo $sampleString; 
            // die();
            
            $hashKey = 'L3L9LHA58FE7BCU3';
            $cipher = "aes-128-ecb";
            $crypttext = openssl_encrypt($sampleString, $cipher, $hashKey,OPENSSL_RAW_DATA);
            $hashRequest = base64_encode($crypttext);
            
            return response()->json(['param' => $hashRequest, 'ss' => $sampleString]);
        }
        
        catch(\Throwable $e){
            echo "something went wrong ". $e->getMessage();
        }
    }
    
    
        public function getJazz(){
           return view('jaxxcash/jaxxcash');
        }
        
        
        public function jazzcashCallBack(Request $request){
            dd($request->all())   ;
        }


        public function getStarted($course)
        {
            try{
                $slug = $course;
                $course = Course::where('slug' ,$course)->first();
                if(!$course){
                    abort(403);
                }

                $price = $course->price->pricing;
                $pkr_c = $this->getPayment();
                $price = round($price * $pkr_c, 2);
                $timestamp = strtotime(date("h:i:sa")) + 2*60*60;
                $time = date('Y-m-d h:i:s', $timestamp);
                return view('easypaisa.send-request-easypaisa',compact('price','time','slug'));
            }
            catch(\Throwable $e){
                return back();
            }
        }
    
    
}
