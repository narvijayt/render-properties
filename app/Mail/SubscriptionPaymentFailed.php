<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;

class SubscriptionPaymentFailed extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
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
        $user =$this->user;
        // return $this->view('view.name');
        return $this->from(config('mail.from.address'), 'Render')
			->subject("Render: Subscription Failed")
            ->markdown('email.subscription.payment-failed', compact('user'));
    }
}
