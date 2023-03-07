<?php

namespace App\Listeners\Subscriptions;

use App\Events\Subscriptions\ChangedSubscription;
use App\Mail\Subscriptions\ChangeSubscription;

class ChangedSubscriptionNotification
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
     * @param  ChangedSubscription  $event
     * @return void
     */
    public function handle(ChangedSubscription $event)
    {
        $mail = new ChangeSubscription($event->subscription, $event->plan);

        \Mail::to($event->subscription->user->email)->send($mail);
    }
}
