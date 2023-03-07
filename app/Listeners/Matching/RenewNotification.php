<?php

namespace App\Listeners\Matching;

use App\Events\Matching\Renew;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\Matching\Renew as RenewEmail;

class RenewNotification implements ShouldQueue
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
     * @param  Renew  $event
     * @return void
     */
    public function handle(Renew $event)
    {
		if($event->user->settings->email_receive_match_requests) {
			$email = new RenewEmail($event->match, $event->user);
			\Mail::to($event->user->email)->send($email);
		}
    }
}
