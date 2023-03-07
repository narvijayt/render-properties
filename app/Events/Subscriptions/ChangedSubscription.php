<?php

namespace App\Events\Subscriptions;

use App\BraintreePlan;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Laravel\Cashier\Subscription;

class ChangedSubscription
{
    use Dispatchable, SerializesModels;

	/**
	 * @var Subscription
	 */
    public $subscription;

	/**
	 * @var BraintreePlan
	 */
    public $plan;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Subscription $subscription, BraintreePlan $plan)
    {
        $this->subscription = $subscription;
        $this->plan = $plan;
    }
}
