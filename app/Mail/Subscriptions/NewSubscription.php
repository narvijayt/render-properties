<?php

namespace App\Mail\Subscriptions;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Cashier\Subscription;

class NewSubscription extends Mailable
{
    use Queueable, SerializesModels;

	/**
	 * @var Subscription
	 */
	protected $subscription;

    /**
     * Create a new message instance.
     *
     * @return void
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

        return $this->subject('')
            ->from(config('mail.from.address'))
			->markdown('email.subscription.new', [
				'user' => $this->subscription->user
			]);
    }
}
