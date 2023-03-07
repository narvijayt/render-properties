<?php

namespace App\Events\Matching;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\User;

class NewMatchSuccess
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
