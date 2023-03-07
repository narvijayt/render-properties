<?php

namespace App\Events\Matching;

use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RenewSuccess
{
	use Dispatchable, SerializesModels;

	/**
	 * @var User
	 */
	public $user1;

	/**
	 * @var User
	 */
	public $user2;

	/**
	 * NewMatchSuccess constructor.
	 *
	 * @param User $user1
	 * @param User $user2
	 */
	public function __construct(User $user1, User $user2)
	{
		$this->user1 = $user1;
		$this->user2 = $user2;
	}
}
