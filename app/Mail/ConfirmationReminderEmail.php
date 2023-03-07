<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConfirmationReminderEmail extends Mailable
{
    use Queueable, SerializesModels;
	/**
	 * @var User
	 */
	public $user;

	/**
	 * @var integer
	 */
	public $areaUsers;

	/**
	 * @var integer
	 */
	public $newAreaUsers;

	/**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $areaUsers, $newAreaUsers)
    {
		$this->user = $user;
		$this->areaUsers = $areaUsers;
		$this->newAreaUsers = $newAreaUsers;
	}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.email-confirmation-reminder')
			->subject($this->user->first_name.', please confirm your email address with Render');
    }
}
