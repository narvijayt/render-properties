<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Http\Request;
use App\User;
use DB;
use App\Http\Controllers\Controller;

use App\Services\MobileVerificationService;
use App\Services\TwilioService;
use App\Http\Traits\AutoMatchTrait;

class VerifyMobileController extends Controller
{
    // use AutoMatchTrait Trait
	use AutoMatchTrait;
    
    public function sendOTPToVerifyMobile($id = ''){
        if(empty($id)){
            flash('Invalid User ID.')->error();
            return redirect()->route("login");
        }

        $user = User::find($id);

        if($user->mobile_verified == 1){
            flash("Your Phone Number has already been verified.")->success();
            return redirect()->route("login");
        }

        if(isset($user->phone_number) && !empty($user->phone_number) ){
            $response = (new MobileVerificationService())->generateOtp($user->user_id);
            // echo '<pre>'; print_r($response); die;

            (new TwilioService())->sendOTPVerificationSMS($user, $response->otp);

            flash("OTP has been sent successfully")->success();
            return redirect()->route('verify.phone', ['id' => $user->user_id]);
        }
    }

    public function verifyTestOTP($id){
        if(empty($id)){
            flash('Invalid User ID.')->error();
            return redirect()->route("login");
        }

        $user = User::find($id);

        if($user->mobile_verified == 1){
            flash("This link has been expired.")->success();
            return redirect()->route("login");
        }

        return view('auth.verify-otp', compact('user') );
    }
    
    public function verifyOTP(Request $request){

        $user = User::find($request->user_id);
        if($user->mobile_verified == 1){
            flash("This OTP has been expired.")->success();
            return redirect()->route("login");
        }

        $response = (new MobileVerificationService())->verifyOTPCode($request->user_id, $request->otp);
        if($response['success'] == true){
            flash($response['message'])->success();
            if($user->user_type == "realtor"){
                return redirect()->route("login");
            }else{
                if($user->payment_status == 0){
                    $this->sendAutoMatchRequests($user->user_id);
                    return redirect()->route('register.thankyou', ['id' => $user->user_id]);
                }else{
                    return redirect()->route("login");
                }
            }
        }else{
            flash($response['message'])->error();
            if($response['message'] == "Your OTP has been expired."){
                if($this->resendOTPAgain($user->user_id)){
                    flash("OTP has been sent successfully")->success();
                }
            }
            return redirect()->route('verify.phone', ['id' => $user->user_id]);
        }
    }

    
    public function reSendNewOTP($id = ''){
        
        if(empty($id)){
            flash('Invalid User ID.')->error();
            return redirect()->route("login");
        }

        $user = User::find($id);

        if($user->mobile_verified == 1){
            flash("Your Phone Number has already been verified.")->success();
            return redirect()->route("login");
        }

        if(isset($user->phone_number) && !empty($user->phone_number) ){
            if($this->resendOTPAgain($user->user_id)){
                flash("OTP has been sent successfully")->success();
                return redirect()->route('verify.phone', ['id' => $user->user_id]);
            }
        }
    }

    public function resendOTPAgain($id = ''){
        
        if(empty($id))
            return false;

        $user = User::find($id);

        if(isset($user->phone_number) && !empty($user->phone_number) ){
            $response = (new MobileVerificationService())->regenerateOtp($user->user_id);
            // echo '<pre>'; print_r($response); die;
            (new TwilioService())->sendOTPVerificationSMS($user, $response->otp);
        }
        return true;
    }
}
