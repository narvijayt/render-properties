<?php
namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RenewMatchRequestEmail extends Mailable
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
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
    	$authUser = auth()->user();
       
        return $this->from(config('mail.from.address'), 'Render')
		->subject(ucfirst($authUser->first_name).' wants renew the match request')
        ->markdown('email.matching.renew-match-request');
        
    }
}