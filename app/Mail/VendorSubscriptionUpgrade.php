<?php
namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VendorSubscriptionUpgrade extends Mailable
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
    public function __construct($user)
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
       if($this->user[0]->user_type == 'vendor') {
            return $this->from(config('mail.from.address'))
			->subject("Upgraded Subscription Plan")
            ->markdown('email.auth.vendor-upgrade-text');
        } 
    }
}