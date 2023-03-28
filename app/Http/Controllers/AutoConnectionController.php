<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use Mail;
use App\Match;
use App\Mail\NewLenderNotificationToRealtors;
use App\Mail\AutoMatchNotificationToLender;
use App\Services\TwilioService;

use App\Http\Traits\AutoMatchTrait;

class AutoConnectionController extends Controller
{
    use AutoMatchTrait;

    //
    public function sendAutoMatchRequests($user_id = ''){
        if(empty($user_id))
            die("failed 1");

        $user = User::find($user_id);
        if($user->user_type != 'broker')
            die("failed 2");

        if($user->verified == false)
            die("failed 3");

        if($user->mobile_verified == false)
            die("failed 4");

        if($user->payment_status == false)
            die("failed 5");

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
    }

    public function viewAutoMatchRequest($brokerId, $realtorId){
        $user = User::find($brokerId);
        $realtorUser = User::find($realtorId);
        
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
                $matchBrokerUser = User::find($broker_user_id);
                //if(in_array($realtorUser->zip,explode(",",$matchBrokerUser->zip) )){
                    if($broker_user_id == $user->user_id){
                        flash('You already have connected with this Loan Officer.')->error();
                        return redirect()->route('lenderdetails.automatch', ['brokerId' => $brokerId, 'realtorId' => $realtorId ]);
                    }else{
                        flash('You already have an connection with another Loan Office within the same ZIP Code area.')->error();
                        return redirect()->route('login');
                    }
                //}
            }
        }

        if($connection_exists == false){
            return view('pub.auto.view', compact('user', 'realtorUser') );
        }
    }

    public function requestAutoMatch(Request $request, $brokerId, $realtorId){
        $brokerUser = User::find($brokerId);
        $realtorUser = User::find($realtorId);

        $matches = Match::findForUser($realtorUser, true);
        if($matches->count() ){
            flash('You are already connected with another loan office in same area. Can not create new connection with multiple loan officers.')->error();
            return redirect()->back();
        }

        if(!in_array($realtorUser->zip,explode(",",$brokerUser->zip) )){
            flash('This user does not belong to your service area. You can not connect to this user.')->error();
            return redirect()->back();
        }

        // $this->authorize('requestMatch', $brokerUser);
        $matchingService = app()->make(\App\Services\Matching\Matching::class);
        $match = $matchingService->request($brokerUser, $realtorUser);
        if ($match !== false) {
            $matchingService->accept($match->match_id, $brokerUser);
            $matchingService->accept($match->match_id, $realtorUser);

            $response = (new TwilioService())->sendRealtorConnectToLender($brokerUser, $realtorUser);
            $email = new AutoMatchNotificationToLender($brokerUser, $realtorUser);
            Mail::to($brokerUser->email)->send($email);

            flash('You are now connected with Loan Officer')->success();
            return redirect()->route('lenderdetails.automatch', ['brokerId' => $brokerId, 'realtorId' => $realtorId ]);
        }

        flash('Something went wrong! Please try again.')->error();
        return redirect()->back();
    }

    public function acceptAutoMatch($brokerUser, $realtorUser){

        $this->authorize('confirmMatch', $brokerUser);        
        $matchingService = app()->make(\App\Services\Matching\Matching::class);
        $match = $matchingService->findForUsers($brokerUser, $realtorUser);
        if ($match === false ) 
        {
            flash('Unable to confirm match')->error();
            return redirect()->back();
        }
        if ($matchingService->accept($match->match_id, $realtorUser) !== true) 
        {
            flash('Unable to confirm match')->error();
            return redirect()->back();
        }
        flash('You have successfully matched with '.$brokerUser->full_name())->success();
        return redirect()->back();
    }

    public function lenderDetails($brokerId, $realtorId){
        $user = User::find($brokerId);
        $realtorUser = User::find($realtorId);

        $match = Match::findForUsers($realtorUser, $user);
        if(empty($match))
            return redirect()->route('view.automatch', ['brokerId' => $brokerId, 'realtorId' => $realtorId ] );

        return view('pub.auto.view', compact('user', 'realtorUser', 'match') );
    }
    
    
    public function realtorDetails($brokerId, $realtorId){
        $brokerUser = User::find($brokerId);
        $user = User::find($realtorId);

        $match = Match::findForUsers($user, $brokerUser);
        /*if(empty($match)){
            flash('No Match found.')->error();
            return redirect()->route('login');
        }*/
        $lendorView = true;
        return view('pub.auto.view', compact('brokerUser', 'user', 'match', 'lendorView') );
    }

    public function pr($array = [], $die = false){
        echo  '<pre>'; print_r($array); echo '<pre>';
        if($die == true)    
            die;
    }
}
