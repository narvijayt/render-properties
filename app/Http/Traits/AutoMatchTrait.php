<?php
namespace App\Http\Traits;

use App\User;
use DB;
use Mail;
use App\Match;
use App\Mail\NewLenderNotificationToRealtors;
use App\Mail\AutoMatchNotificationToLender;
use App\Services\TwilioService;


trait AutoMatchTrait {
    public function sendAutoMatchRequests($user_id = ''){
        if(empty($user_id))
            return false;

        $user = User::find($user_id);
        
        if($user->user_type != 'broker')
            return false;

        if($user->verified == false)
            return false;

        if($user->mobile_verified == false)
            return false;

        if($user->payment_status == false)
            return false;
        
        if($user->auto_notifications == 1)
            return false;

        $realtorUsers = User::where("user_type", 'realtor')->whereIn("zip", explode(",",$user->zip))->take(10)->get();
        if($realtorUsers->count()){
            foreach($realtorUsers as $realtor){
                $realtorUser = User::find($realtor->user_id);
                $matches = Match::findForUser($realtorUser, true);
                $connection_exists = false;
                if($matches->count() ){
                    $broker_user_id = '';
                    foreach($matches as $match){
                        if($match->user_id1 == $realtorUser->user_id){
                            $broker_user_id = $match->user_id2;
                        }else{
                            $broker_user_id = $match->user_id1;
                        }
                        $brokerUser = User::find($broker_user_id);
                        if(in_array($realtorUser->zip,explode(",",$brokerUser->zip) )){
                            $connection_exists = true;
                            break;
                        }
                    }
                }

                if($connection_exists == false){
                    $response = (new TwilioService())->sendAutoMatchRequestSMS($user, $realtor);
                    $email = new NewLenderNotificationToRealtors($user, $realtor);
                    Mail::to($realtor->email)->send($email);
                }
            }
        }

        $user->auto_notifications = 1;
        $updateUser = $user->update();

        return true;
    }
}