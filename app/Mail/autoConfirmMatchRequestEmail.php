<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class autoConfirmMatchRequestEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $authUser;

    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $authUser, User $user)
    {
        $this->authUser = $authUser;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
		->subject(ucfirst($this->authUser->first_name).' has accepted your match request')
        ->markdown('email.matching.confirm-match-request');
    }
}
