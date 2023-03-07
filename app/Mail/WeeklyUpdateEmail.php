<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WeeklyUpdateEmail extends Mailable
{
    use Queueable, SerializesModels;

	/**
	 * @var User
	 */
	public $user;

	/**
	 * @var integer
	 */
	public $matches;

	/**
	 * @var int
	 */
	public $unreadCount;

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
    public function __construct(User $user, $matches, $unreadCount, $areaUsers, $newAreaUsers)
    {
		$this->user = $user;
		$this->matches = $matches;
		$this->unreadCount = $unreadCount;
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
        return $this->markdown('email.weekly-update')
			->subject($this->user->first_name.' see what you\'ve missed on Render');
    }
}
