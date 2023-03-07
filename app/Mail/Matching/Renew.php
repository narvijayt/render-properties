<?php

namespace App\Mail\Matching;

use App\Match;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Renew extends Mailable
{
    use Queueable, SerializesModels;

	/**
	 * @var Match
	 */
    protected $match;

	/**
	 * @var User
	 */
    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Match $match, User $user)
    {
        $this->match = $match;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		$fromUser = $this->match->getOppositeParty($this->user);

        return $this->subject('Match Renewal Request received from '.$fromUser->full_name())
            ->from(env('MAIL_FROM_ADDRESS'))
			->markdown('email.matching.renew', [
				'match' => $this->match,
				'recipient' => $this->user,
				'fromUser' => $fromUser,
			]);
    }
}
