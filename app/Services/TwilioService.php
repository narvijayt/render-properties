<?php

namespace App\Services;

use Carbon\Carbon;
use App\User;
use Twilio\Rest\Client;

class TwilioService{

    public function sendOTPVerificationSMS( object $user, $otp){
        $this->sendSMS( $user->phone_number, 'Hey '.$user->first_name.'! Your OTP Code for Render: '.$otp);
    }

    public function sendAutoMatchRequestSMS($lendor, $realtor){
        $this->sendSMS( $realtor->phone_number, 'Hey '.$realtor->first_name.'! Time to increase your sales! Congratulations a Loan Officer in your area, '.$lendor->first_name.' '.$lendor->last_name.' wants to connect with you. Click on the link below to see details: '.route('view.automatch', ['brokerId' => $lendor->user_id, 'realtorId' => $realtor->user_id]) );
    }
    
    public function sendRealtorConnectToLender($lendor, $realtor){
        $this->sendSMS( $lendor->phone_number, 'Hey '.$lendor->first_name.'! Congratulations, a Real Estate Agent in your area '.$realtor->first_name.' '.$realtor->last_name.' has connected with you. Click on the link below to see the details '.route('realtordetails.automatch', ['brokerId' => $lendor->user_id, 'realtorId' => $realtor->user_id]) );
    }

    public function sendSMS($to, $body){
        $client = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
            
        return $client->messages->create(
            // the number you'd like to send the message to
            $to,
            // '+17048395599',
            [
                'from' => env('TWILIO_NUMBER'),
                'body' => $body
            ]
        );
    }
}