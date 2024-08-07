<?php
namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConfirmMatchRequestEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    /**
     * Create a new message instance.
     *
	 * @param User $user
	 *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $authUser = auth()->user();
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
		->subject(ucfirst($authUser->first_name).' has accepted your match request')
        ->markdown('email.matching.confirm-match-request');
        
    }
}