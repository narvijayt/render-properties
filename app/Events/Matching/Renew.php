<?php

namespace App\Events\Matching;

use App\Match;
use App\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Renew
{
    use Dispatchable, SerializesModels;

	/**
	 * @var Match
	 */
	public $match;

	/**
	 * @var User
	 */
	public $user;

	/**
	 * Renew constructor.
	 *
	 * @param Match $match
	 * @param User $user
	 */
	public function __construct(Match $match, User $user)
	{
		$this->match = $match;
		$this->user = $user;
	}
}
