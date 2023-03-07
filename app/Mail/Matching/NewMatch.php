<?php

namespace App\Mail\Matching;

use App\Match;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewMatch extends Mailable
{
    use Queueable, SerializesModels;

	/**
	 * @var Match
	 */
    protected $match;

	/**
	 * @var
	 */
    protected $recipient;

	/**
	 * NewMatch constructor.
	 *
	 * @param Match $match
	 * @param User $recipient
	 */
    public function __construct(Match $match, User $recipient)
    {
        $this->match = $match;
        $this->recipient = $recipient;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
    	$fromUser = $this->match->getOppositeParty($this->recipient);
        return $this->subject('New Match Request From '.$fromUser->first_name)
            ->from(env('MAIL_FROM_ADDRESS'))
        	->markdown('email.matching.new', [
				'match' => $this->match,
				'recipient' => $this->recipient,
				'from_user' => $fromUser,
			]);
    }
}
