<?php

namespace App\Mail\Subscriptions;

use App\BraintreePlan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Cashier\Subscription;

class ChangeSubscription extends Mailable
{
    use Queueable, SerializesModels;

	/**
	 * @var Subscription
	 */
    protected $subscription;

	/**
	 * @var BraintreePlan
	 */
    protected $plan;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Subscription $subscription, BraintreePlan $plan)
    {
        $this->subscription = $subscription;
        $this->plan = $plan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Subscription Changed')
            ->from(config('mail.from.address'))
			->markdown('email.subscription.change', [
				'subscription' => $this->subscription,
				'user' => $this->subscription->user,
				'plan' => $this->plan,
			]);
    }
}
