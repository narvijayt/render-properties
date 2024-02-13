<?php

namespace App\Services;

use Carbon\Carbon;
use App\User;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class TwilioService{

    public function sendOTPVerificationSMS( object $user, $otp){
        $this->sendSMS( $user->phone_number, 'Hey '.$user->first_name.'! Your OTP Code for Render: '.$otp);
    }
    
    public function sendLoginOTPVerificationSMS( object $user, $otp){
        
        $this->sendSMS( $user->phone_number, 'Hey '.$user->first_name.'! Your OTP Code to login your account in Render is: '.$otp);
    }

    public function sendAutoMatchRequestSMS($lendor, $realtor){
        // $this->sendSMS( $realtor->phone_number, 'Hey '.$realtor->first_name.'! Time to increase your sales! Congratulations, a Loan Officer in your area, '.$lendor->first_name.' '.$lendor->last_name.' wants to connect with you. Click on the link below to see the details. '.route('view.automatch', ['brokerId' => $lendor->user_id, 'realtorId' => $realtor->user_id]) );
        $this->sendSMS( $realtor->phone_number, 'Hey '.$realtor->first_name.'! Congratulations, a Loan Officer in your area wants to get buyer leads started. Match with '.$lendor->first_name.' '.$lendor->last_name.' and start the leads today. Click on the link below to see details: '.route('view.automatch', ['brokerId' => $lendor->user_id, 'realtorId' => $realtor->user_id]) );
    }
    
    public function sendRealtorConnectToLender($lendor, $realtor){
        // $this->sendSMS( $lendor->phone_number, 'Hey '.$lendor->first_name.'! Congratulations, a Real Estate Agent in your area '.$realtor->first_name.' '.$realtor->last_name.' has connected with you. Click on the link below to see the details. '.route('realtordetails.automatch', ['brokerId' => $lendor->user_id, 'realtorId' => $realtor->user_id]) );
        $this->sendSMS( $lendor->phone_number, 'Hey '.$lendor->first_name.'! Congratulations, a Real Estate Agent in your area '.$realtor->first_name.' '.$realtor->last_name.' has connected with you. Click on the link below to see the details '.route('realtordetails.automatch', ['brokerId' => $lendor->user_id, 'realtorId' => $realtor->user_id]) );
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

        $this->sendSMS( $conversationData['recipient']->phone_number, 'Hey '.$conversationData['recipient']->first_name.'! You have received a new message from a '.$userType.'. Click on the link below to check the message and reply '. route('pub.message-center.index') );
    }

    /**
     * Send SMS Notification when Lender or Realtor Send Manual Match Request to Each Other
     * 
     */
    public function sendNewRequestMatchNotification($authUser, $user){
        // $this->sendSMS( $user->phone_number, 'Hey '.$user->first_name.'! you have received a new match request from '.$authUser->first_name.'. You can view the request in your profile '. route('pub.profile.matches.index') );
        
        $this->sendSMS( $user->phone_number, 'Hey '.$user->first_name.'! you have received a new match request from '.$authUser->first_name.'. Click on the link below to check the details '. route('view.automatch', ['authUser' => $user->user_id, 'user' => $authUser->user_id]) );
    }
    
    /**
     * Send SMS Notification when Lender or Realtor Accepts Manual Match Requestm received from Each Other
     * 
     */
    public function sendMatchAcceptedNotification($authUser, $user){
        $this->sendSMS( $user->phone_number, 'Hey '.$user->first_name.'! Congratulations, '.$authUser->first_name.' has accpeted your match request. Click on the link below to check the details '. route('matchdetails.automatch', ['authUser' => $user->user_id, 'user' => $authUser->user_id]) );
    }

    public function sendSMS($to, $body){
        $client = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
            
        try{
            return $client->messages->create(
                // the number you'd like to send the message to
                // env('APP_ENV') != 'production' ? env('TWILIO_TO_NUMBER') : '+17048395599',
                env('APP_ENV') == 'local' ? env('TWILIO_TO_NUMBER') : $to,
                [
                    // 'from' => env('TWILIO_NUMBER'),
                    "messagingServiceSid" => env('TWILIO_SERVICE_SID'),
                    'body' => $body
                ]
            );
        }catch (\Exception $e) {
            // return $e->getMessage();
            Log::info($e->getMessage());
            return false;
        }
    }
}