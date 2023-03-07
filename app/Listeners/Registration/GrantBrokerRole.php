<?php

namespace App\Listeners\Registration;

use App\Events\Registration\BrokerRegistered;
use App\Role;

class GrantBrokerRole
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
     * @param  BrokerRegistered  $event
     * @return void
     */
    public function handle(BrokerRegistered $event)
    {
        $event->user->assign(['user', 'broker']);
    }
}
