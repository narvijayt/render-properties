<?php

namespace App\Events\Matching;

use App\Match;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMatch
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
	 * NewMatch constructor.
	 *
	 * @param Match $match
	 * @param User $user
	 */
    public function __construct(Match $match, User $user)
    {
        $this->match = $match;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
//    public function broadcastOn()
//    {
//        return new PrivateChannel('channel-name');
//    }
}
