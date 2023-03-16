<?php

namespace App\Mail\Subscriptions;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Cashier\Subscription;

class CancelSubscription extends Mailable
{
    use Queueable, SerializesModels;

	/**
	 * @var Subscription
	 */
    protected $subscription;

	/**
	 * CancelSubscription constructor.
	 * @param Subscription $subscription
	 */
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Subscription Cancelled")
            ->from(config('mail.from.address'))
			->markdown('email.subscription.cancel', [
				'user' => $this->subscription->user,
			]);
    }
}
