<?php
namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConversationNotificationEmail extends Mailable
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
        return $this->from(config('mail.from.address'), config('mail.from.name'))
		->subject("{$this->user['receiver_first_name']} you have received new message from {$this->user['sender_first_name']}")
            ->markdown('email.auth.conversation_email');
    }
}