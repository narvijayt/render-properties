<?php

namespace App\Services;

use Carbon\Carbon;
use App\VerificationCode;
use App\User;

class MobileVerificationService{
    
    // Generate New OTP Code
    public function generateOtp($user_id)
    {
        $user = User::find($user_id);
        // $user = User::where('phone_number', $mobile_no)->first();

        // echo '<pre>'; print_r($user); die;
        # User Does not Have Any Existing OTP
        $verificationCode = VerificationCode::where('user_id', $user->user_id)->latest()->first();

        $now = Carbon::now();

        if($verificationCode && $now->isBefore($verificationCode->expire_at)){
            return $verificationCode;
        }

        // Create a New OTP
        return VerificationCode::create([
            'user_id' => $user->user_id,
            'otp' => rand(123456, 999999),
            'expire_at' => Carbon::now()->addMinutes(10)
        ]);
    }

    // Verify OTP Code
    public function verifyOTPCode($user_id, $otp)
    {

        #Validation Logic
        // echo $user_id.' and '.$otp;
        // VerificationCode::where('user_id', $user_id)->where('otp', $otp)->toSql(); die;
        $verificationCode   = VerificationCode::where('user_id', $user_id)->where('otp', $otp)->first();
        // echo '<pre>'; print_r($verificationCode); die;

        $now = Carbon::now();
        if (!$verificationCode) {
            return array("status" => 200, "success" => false, "message" => "Your OTP is not correct." );
        }elseif($verificationCode && $now->isAfter($verificationCode->expire_at)){
            return array("status" => 200, "success" => false, "message" => "Your OTP has been expired." );
        }

        $user = User::find($user_id);

        if($user){
            // Expire The OTP
            $verificationCode->update([
                'expire_at' => Carbon::now()
            ]);

            $user->mobile_verified = 1;
            
            $user->update();

            return array("status" => 200, "success" => true, "message" => "Your Mobile has been verified Successfully." );
        }else{
            return array("status" => 200, "success" => false, "message" => "Your Otp is not correct." );
        }
    }

    // Resend New OTP Code
    public function regenerateOtp($user_id)
    {
        $user = User::find($user_id);
        // $user = User::where('phone_number', $mobile_no)->first();

        // echo '<pre>'; print_r($user); die;
        # User Does not Have Any Existing OTP
        $verificationCode = VerificationCode::where('user_id', $user->user_id)->latest()->first();

        $now = Carbon::now();

        if($verificationCode && $now->isBefore($verificationCode->expire_at)){
            // return $verificationCode;
            $verificationCode->update([
                'expire_at' => Carbon::now()
            ]);
        }

        // Create a New OTP
        return VerificationCode::create([
            'user_id' => $user->user_id,
            'otp' => rand(123456, 999999),
            'expire_at' => Carbon::now()->addMinutes(10)
        ]);
    }
}