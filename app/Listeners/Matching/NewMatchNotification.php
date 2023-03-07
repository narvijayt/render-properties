<?php

namespace App\Listeners\Matching;

use App\Events\Matching\NewMatch;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\Matching\NewMatch as NewMatchEmail;

class NewMatchNotification implements ShouldQueue
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
     * @param  NewMatch  $event
     * @return void
     */
    public function handle(NewMatch $event)
    {
    	if($event->user->settings->email_receive_match_requests) {
			$email = new NewMatchEmail($event->match, $event->user);

			\Mail::to($event->user->email)->send($email);
		}
    }
}
