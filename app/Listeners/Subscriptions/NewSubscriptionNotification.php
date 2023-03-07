<?php

namespace App\Listeners\Subscriptions;

use App\Events\Subscriptions\NewSubscription;
use App\Mail\Subscriptions\NewSubscription as NewSubscriptionEmail;

class NewSubscriptionNotification
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
     * @param  NewSubscription  $event
     * @return void
     */
    public function handle(NewSubscription $event)
    {
        $email = new NewSubscriptionEmail($event->subscription);
        \Mail::to($event->subscription->user->email)->send($email);
    }
}
