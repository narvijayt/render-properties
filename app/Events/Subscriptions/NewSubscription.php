<?php

namespace App\Events\Subscriptions;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Laravel\Cashier\Subscription;

class NewSubscription
{
    use Dispatchable, SerializesModels;

	/**
	 * @var Subscription
	 */
    public $subscription;

	/**
	 * NewSubscription constructor.
	 *
	 * @param Subscription $subscription
	 */
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }
}
