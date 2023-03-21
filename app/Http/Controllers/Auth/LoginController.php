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
use App\Mail\SendLoginOTPNotification;
use Auth;
use Mail;


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
        if(is_numeric($request->input('email') )){
            $usr = User::whereRaw("replace(phone_number, '-', '') = '".trim($request->get('email'))."' " )->first();
        }else{
            $usr = User::where('email', '=', $request->get('email') )->first();
        }

        if(!empty($usr)) {
            if($request->input('loginWithOTP') == 1){
                $response = (new MobileVerificationService())->generateOtp($usr->user_id);    
                // echo '<pre>'; print_r($response); die;
                (new TwilioService())->sendLoginOTPVerificationSMS($usr, $response->otp);
                $email = new SendLoginOTPNotification($usr, $response->otp);
                Mail::to($usr->email)->send($email);
    
                flash("OTP has been sent successfully")->success();
                return redirect()->route('login.addotp', ['user_id' => $usr->user_id]);
            }

            
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
     * 
     * 
     */
    public function addLoginOTP($user_id){
        if(empty($user_id)){
            flash('Invalid request!')->error();
            return redirect()->route('login');
        }

        $user = User::find($user_id);
        if(empty($user)){
            flash('Invalid request!')->error();
            return redirect()->route('login');
        }

        return view('auth.addotp', compact('user') );
    }


    /**
     * 
     * 
     */
    public function resendloginotp($user_id){
        if(empty($user_id)){
            flash('Invalid User ID.')->error();
            return redirect()->back();
        }

        $user = User::find($user_id);
        if($this->resendOTPAgain($user->user_id)){
            flash("A new OTP has been sent successfully")->success();
            return redirect()->route('login.addotp', ['user_id' => $user->user_id]);
        }
    }

    /**
     * 
     * 
     */
    public function verifyLoginOTP(Request $request){
        $user = User::find($request->user_id);

        $response = (new MobileVerificationService())->verifyOTPCode($request->user_id, $request->otp);
        if($response['success'] == true){
            // flash($response['message'])->success();
            if($user->user_type == "realtor"){
                Auth::login($user);
                return $this->sendLoginResponse($request);
            }else{
                if($user->payment_status == 0){
                    return redirect()->route('register.thankyou', ['id' => $user->user_id]);
                }else{
                    Auth::login($user);
                    return $this->sendLoginResponse($request);
                }
            }
        }else{
            flash($response['message'])->error();
            if($response['message'] == "Your OTP has been expired."){
                if($this->resendLoginOTPAgain($user->user_id)){
                    flash("OTP has been sent successfully")->success();
                }
            }
            return redirect()->route('login.addotp', ['id' => $user->user_id]);
        }
    }

    /**
     * 
     * 
     */
    public function resendLoginOTPAgain($id = ''){
        
        if(empty($id))
            return false;

        $user = User::find($id);

        if(isset($user->phone_number) && !empty($user->phone_number) ){
            $response = (new MobileVerificationService())->regenerateOtp($user->user_id);
            (new TwilioService())->sendLoginOTPVerificationSMS($user, $response->otp);
            return true;
        }
        return false;
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
