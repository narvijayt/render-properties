<?php

namespace App\Listeners\Registration;

use App\Events\Registration\RealtorRegistered;
use App\Role;

class GrantRealtorRole
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
     * @param  RealtorRegistered  $event
     * @return void
     */
    public function handle(RealtorRegistered $event)
    {
        $event->user->assign(['user', 'realtor']);
    }
}
