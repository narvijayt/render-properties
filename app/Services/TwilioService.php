<?php

namespace App\Services;

use Carbon\Carbon;
use App\User;
use Twilio\Rest\Client;

class TwilioService{

    public function sendOTPVerificationSMS( object $user, $otp){
        $this->sendSMS( $user->phone_number, 'Hey '.$user->first_name.'! Your OTP Code for Render: '.$otp);
    }
    
    public function sendLoginOTPVerificationSMS( object $user, $otp){
        $this->sendSMS( $user->phone_number, 'Hey '.$user->first_name.'! Your OTP Code to login youar account in Render is: '.$otp);
    }

    public function sendAutoMatchRequestSMS($lendor, $realtor){
        $this->sendSMS( $realtor->phone_number, 'Hey '.$realtor->first_name.'! Time to increase your sales! Congratulations, a Loan Officer in your area, '.$lendor->first_name.' '.$lendor->last_name.' wants to connect with you. Click on the link below to see the details. '.route('view.automatch', ['brokerId' => $lendor->user_id, 'realtorId' => $realtor->user_id]) );
    }
    
    public function sendRealtorConnectToLender($lendor, $realtor){
        $this->sendSMS( $lendor->phone_number, 'Hey '.$lendor->first_name.'! Congratulations, a Real Estate Agent in your area '.$realtor->first_name.' '.$realtor->last_name.' has connected with you. Click on the link below to see the details. '.route('realtordetails.automatch', ['brokerId' => $lendor->user_id, 'realtorId' => $realtor->user_id]) );
    }

    public function sendConversationNotificationSMS($conversationData){
        $userType = $conversationData['currentUser']->user_type == 'broker' ? 'Lender' : 'Realtor';
        /*if($conversationData['currentUser']->user_type == 'broker'){
            $brokerId = $conversationData['currentUser']->user_id;
            $realtorId = $conversationData['recipient']->user_id;
        }else{
            $realtorId = $conversationData['currentUser']->user_id;
            $brokerId = $conversationData['recipient']->user_id;
        }*/
        $this->sendSMS( $conversationData['recipient']->phone_number, 'Hey '.$conversationData['recipient']->first_name.'! You have received a new message from a '.$userType.'. Click on the link below to check the message and reply '. route('message-center.index') );
    }

    public function sendSMS($to, $body){
        $client = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
            
        return $client->messages->create(
            // the number you'd like to send the message to
            // env('APP_ENV') != 'production' ? '+918968001610' : '+17048395599',
            env('APP_ENV') != 'production' ? '+918968001610' : $to,
            [
                'from' => env('TWILIO_NUMBER'),
                'body' => $body
            ]
        );
    }
}