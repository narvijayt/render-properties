<?php

namespace App\Listeners\Matching;

use App\Events\Matching\RenewSuccess;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\Matching\RenewSuccess as RenewSuccessEmail;

class RenewSuccessNotification implements ShouldQueue
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
     * @param  RenewSuccess  $event
     * @return void
     */
    public function handle(RenewSuccess $event)
    {

		if($event->user1->settings->email_receive_match_requests) {
			$user1Mail = new RenewSuccessEmail($event->user1, $event->user2);
			\Mail::to($event->user1->email)->send($user1Mail);
		}

		if($event->user2->settings->email_receive_match_requests) {
			$user2Mail = new RenewSuccessEmail($event->user2, $event->user1);
			\Mail::to($event->user2->email)->send($user2Mail);
		}
    }
}
