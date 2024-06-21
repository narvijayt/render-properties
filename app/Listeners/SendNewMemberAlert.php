<?php

namespace App\Listeners;

use App\Events\NewMemberAlert;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Mail\NotifyUsersNewRegistration;
use Mail;
use App\Services\TwilioService;

class SendNewMemberAlert
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewMemberAlert  $event
     * @return void
     */
    public function handle(NewMemberAlert $event)
    {
        //
        $user = $event->user;
        $registeredMembers = $event->registeredMembers;
        foreach($registeredMembers as $member){
            Mail::to($member->email)->send(new NotifyUsersNewRegistration($user, $member));
            try{
                (new TwilioService())->sendNewMemberNotification($user, $member);
            }catch(Exception $e){
                
            }
        }
    }
}
