<?php
namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MatchLendorRequestEmail extends Mailable
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
		->subject('Deep discount referral fee paid at closing home buyer leads for Realtors.')
        ->markdown('email.matching.lendor-match-request');
        
    }
}