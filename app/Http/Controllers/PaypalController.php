<?php

namespace App\Http\Controllers;

use App\Mail\InformInstructorMail;
use App\Mail\StudentEnrollmentMail;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\CourseHistory;
use App\Models\InstructorEarning;
use App\Models\Pricing;
use App\Models\Setting;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session as FacadesSession;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;

/** All Paypal Details class **/

use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class PaypalController extends Controller
{
    public $_api_context;
    public function __construct()
    {
        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(
            new OAuthTokenCredential(
                $paypal_conf['client_id'],
                $paypal_conf['secret']
            )
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function testingPaypal()
    {
        return view('paypal.testing-p');
    }

    public function testingPaypalPost($slug)
    {
        try {

            $course = Course::with('price')->where('slug', $slug)->where('status', 'published')->first();
            if($course){
                $p = $course->price->pricing;
                $c_name = $course->course_title;
            }else{
                abort(403);
            }
            $price = $p;
            $course_name = $c_name;

            $success_route = URL::route('success.payment');
            $redirect_route = route('a_payment_methods', ['slug' => $course->slug ] );
            $course_id = $course->id;


            $payer = new Payer();
            $payer->setPaymentMethod('paypal');
            $item_1 = new Item();
            $item_1->setName('Course')
                ->setCurrency('USD')
                ->setQuantity(1)
                ->setPrice($price);

            $item_list = new ItemList();
            $item_list->setItems(array($item_1));

            $amount = new Amount();
            $amount->setCurrency('USD')
                ->setTotal($price);

            $transaction = new Transaction();
            $transaction->setAmount($amount)
                ->setItemList($item_list)
                ->setDescription($course_name);


            $redirect_urls = new RedirectUrls();
            $redirect_urls->setReturnUrl($success_route)
                ->setCancelUrl($redirect_route);

            $payment = new Payment();
            $payment->setIntent('Sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirect_urls)
                ->setTransactions(array($transaction));
        } catch (\Throwable $th) {
            return back()->with('error', 'something went wrong');
        }
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            return redirect()->route('index');
        }


        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        FacadesSession::put('paypal_payment_id', $payment->getId());
        FacadesSession::put('course_id', $course_id);

        if (isset($redirect_url)) {
            return Redirect::away($redirect_url);
        }
        \Session::put('error', 'Unknown error occurred');
        return Redirect::route('index');
    }
    public function paymentSuccess(Request $request)
    {
        try {
            $course_id = $request->session()->get('course_id');       
            if ($request->session()->exists('paypal_payment_id')) {
                $c_id = $course_id;
                $u_id = auth()->id();
                $course = Course::with('user')->where('id', $c_id)->first();
                if(!$course){
                    return redirect()->route('index');
                }else{
                    $price = Pricing::where('course_id', $c_id)->first();
                    if($price){
                        $price_in_do = $price->pricing;
                        
                    }else{
                        return Redirect::route('index');
                    }
                }
                CourseEnrollment::create(['course_id' => $c_id, 'user_id' => $u_id]);
                CourseHistory::create(['course_id' => $c_id, 'user_id' => $u_id, 'pay_method' => 'Paypal',
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
            } else {
                abort(403);
            }
        } catch (\Throwable $th) {
            return redirect()->route('index')->with('error', 'something went wrong');
        }
    }

    public function paymentCancel(Request $request)
    {
        echo "<center> you have canpayment has been cancelled </cancel>";
    }
}
