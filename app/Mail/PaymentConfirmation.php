<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Services\Stripe;

class PaymentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        //
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;
        $subscription = [];
        if($user->userSubscription->exists == true){
            $subscription = (new Stripe())->getSubscription($user->userSubscription->stripe_subscription_id);
        }
        // return $this->view('view.name');
        return $this->from(config('mail.from.address'), 'Render')
            ->subject("Render: Payment Invoice")
            ->markdown('email.subscription.payment-invoice', compact('user', 'subscription'));
    }
}
