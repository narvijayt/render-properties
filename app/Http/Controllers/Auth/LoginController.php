<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\Category;
use App\Subscribe;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Services\MobileVerificationService;
use App\Services\TwilioService;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function login(Request $request)
    {
        $usr = User::where('email', '=', $request->get('email') )->first();
        if(!empty($usr)) {
            if($usr['user_type'] == 'vendor'){
                $checkCategory = Category::where('user_id','=',$usr['user_id'])->get();
                if($checkCategory->isNotEmpty()){
                    if($checkCategory[0]->braintree_id !=""){
                        $this->validateLogin($request);
                        if ($request->has('email')) {
                            $request->offsetSet('email', strtolower($request->get('email')));
                        }
                        if ($this->hasTooManyLoginAttempts($request)) {
                            $this->fireLockoutEvent($request);
                            return $this->sendLockoutResponse($request);
                        }
                        if ($this->attemptLogin($request)) {
                            return $this->sendLoginResponse($request);
                        }
                        $this->incrementLoginAttempts($request);
                        return $this->sendFailedLoginResponse($request);
                    }else{
                        return redirect('vendor-packages/'.$usr['user_id'])->with('message','Please make payment for login');
                    }
                }else{
                    return redirect('vendor-packages/'.$usr['user_id'])->with('message','Please make payment for login');
                }
            }
            if($usr['active'] != true) {
                return redirect()->back()->with('message', 'Your account has been deactivated. To activate your account contact to Admin.');
            }
            if($usr['user_type'] == 'broker') {
                
                /*$Subscribe = Subscribe::where('user_id','=',$usr['user_id'])->get();
                if($Subscribe->isNotEmpty()){
                    if($Subscribe[0]->braintree_id !=""){
                        $this->validateLogin($request);
                        if ($request->has('email')) {
                            $request->offsetSet('email', strtolower($request->get('email')));
                        }
                        if ($this->hasTooManyLoginAttempts($request)) {
                            $this->fireLockoutEvent($request);
                            return $this->sendLockoutResponse($request);
                        }
                        if ($this->attemptLogin($request)) {
                            return $this->sendLoginResponse($request);
                        }
                        $this->incrementLoginAttempts($request);
                        return $this->sendFailedLoginResponse($request);
                    }else{
                        return redirect('lender-billing-details/'.$usr['user_id'])->with('error',"Please make payment for login");
                    }
                }else{
                    return redirect('lender-billing-details/'.$usr['user_id'])->with('error',"Please make payment for login");
                }*/
                
                /*if($usr['mobile_verified'] == 0){
                    if(isset($usr['phone_number']) && !empty($usr['phone_number']) ){
                        $response = (new MobileVerificationService())->generateOtp($usr['user_id']);
                        // echo '<pre>'; print_r($response); die;
                        (new TwilioService())->sendOTPVerificationSMS($usr, $response->otp);
            
                        return redirect()->route('verify.phone', ['id' => $usr['user_id'] ])->with('message', 'An OTP has been sent on your registered phone number. Please confirm your contact details.');
                    }else{
                        return redirect('partially-registration/'.$usr['user_id']);
                    }
                }*/
                if($usr['payment_status'] == 0){
                    return redirect()->route('register.accountstatus', ['id' => $usr['user_id'] ])->with('error', 'Your account is not active. Please confirm your payment status with admin to access your account.');
                }
               
                $createdYear = $usr['created_at']->year;
                $time = "2020-01-01 00:00:00";
                $date = new Carbon( $time );   
                $currYear = $date->year;
                if($createdYear >= $currYear){
                    if($usr['billing_first_name'] != '') {
                        if($usr['payment_transaction_id'] == 'cash') {
                            $subscribeUsr = Subscribe::Where('user_id', $usr['user_id'])->first();
                            if(!empty($subscribeUsr)) {
                                $timestamp = strtotime($subscribeUsr['updated_at']);
                                if($subscribeUsr['braintree_id'] == 1) {
                                    $timestamp1 = strtotime("+30 days", $timestamp);
                                } elseif($subscribeUsr['braintree_id'] == 3) {
                                    $timestamp1 = strtotime("+365 days", $timestamp);
                                } elseif($subscribeUsr['braintree_id'] == 5) {
                                    $timestamp1 = strtotime("+60 days", $timestamp);
                                }
                                
                                $currentTime = strtotime(date('Y-m-d'));
                                if($currentTime > $timestamp1) {
                                    return redirect('partially-registration/'.$usr['user_id']);
                                } 
                            }
                        }
                        $this->validateLogin($request);
                        if ($request->has('email')) {
                            $request->offsetSet('email', strtolower($request->get('email')));
                        }
                        if ($this->hasTooManyLoginAttempts($request)) {
                            $this->fireLockoutEvent($request);
                            return $this->sendLockoutResponse($request);
                        }
                        if ($this->attemptLogin($request)) {
                            return $this->sendLoginResponse($request);
                        }
                        $this->incrementLoginAttempts($request);
                        return $this->sendFailedLoginResponse($request);
                    } else {
                        return redirect('partially-registration/'.$usr['user_id']);
                    } 
                }else{
                   $this->validateLogin($request);
                    if ($request->has('email')) {
                        $request->offsetSet('email', strtolower($request->get('email')));
                    }
                    if ($this->hasTooManyLoginAttempts($request)) {
                        $this->fireLockoutEvent($request);
                        return $this->sendLockoutResponse($request);
                    }
                    if ($this->attemptLogin($request)) {
                        return $this->sendLoginResponse($request);
                    }
                    $this->incrementLoginAttempts($request);
                    return $this->sendFailedLoginResponse($request);
                }
            } else {

                /*if($usr['mobile_verified'] == 0){
                    if(isset($usr['phone_number']) && !empty($usr['phone_number']) ){
                        $response = (new MobileVerificationService())->generateOtp($usr['user_id']);
                        // echo '<pre>'; print_r($response); die;
                        (new TwilioService())->sendOTPVerificationSMS($usr, $response->otp);
            
                        return redirect()->route('verify.phone', ['id' => $usr['user_id'] ])->with('message', 'An OTP has been sent on your registered phone number. Please confirm your contact details.');
                    }
                }*/

                $this->validateLogin($request);
                if ($request->has('email')) {
                    $request->offsetSet('email', strtolower($request->get('email')));
                }
                if ($this->hasTooManyLoginAttempts($request)) {
                    $this->fireLockoutEvent($request);
                    return $this->sendLockoutResponse($request);
                }
                if ($this->attemptLogin($request)) {
                    return $this->sendLoginResponse($request);
                }
                $this->incrementLoginAttempts($request);
                return $this->sendFailedLoginResponse($request);
            }
        } else {
            return redirect()->back()->with('message', 'You have entered an invalid email or password.');
        }
    }
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/profile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
