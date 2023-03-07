<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AutoMatchNotificationToLender extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    
     /**
     * @var User
     */
    public $brokerUser;

    /**
     * @var User
     */
    public $realtorUser;

    public function __construct(User $brokerUser, User $realtorUser)
    {
        $this->brokerUser = $brokerUser;
        $this->realtorUser = $realtorUser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'))
            ->subject("Time to increase your sales!")
            ->markdown('email.matching.auto-match-confirmed');
    }
}
