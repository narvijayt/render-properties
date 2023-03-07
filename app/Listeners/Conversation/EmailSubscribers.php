<?php

namespace App\Listeners\Conversation;

use App\Events\Conversation\NewMessage;
use App\Mail\Conversation\NewMessage as MailMessage;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailSubscribers implements ShouldQueue
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
     * @param  NewMessage  $event
     * @return void
     */
    public function handle(NewMessage $event)
    {
		$mail = new MailMessage($event->msg);
		$mail->subject($event->msg->user->first_name.' sent you a message on Real Broker Connection');
    	$mail->toUsers->each(function(User $user) use ($mail) {
    		if($user->settings->email_receive_conversation_messages) {
				Mail::to($user->email)
					->send($mail);
			}
		});
    }
}
