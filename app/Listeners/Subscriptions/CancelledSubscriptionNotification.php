<?php

namespace App\Listeners\Subscriptions;

use App\Events\Subscriptions\CancelledSubscription;
use App\Mail\Subscriptions\CancelSubscription;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CancelledSubscriptionNotification
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
     * @param  CancelledSubscription  $event
     * @return void
     */
    public function handle(CancelledSubscription $event)
    {
        $mail = new CancelSubscription($event->subscription);

        \Mail::to($event->subscription->user->email)->send($mail);
    }
}
