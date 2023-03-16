<?php

namespace App\Mail\Matching;

use App\Enums\UserAccountType;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MatchSuggestions extends Mailable
{
    use Queueable, SerializesModels;

    protected $matches;

    protected $user;

	/**
	 * MatchSuggestions constructor.
	 * @param Collection $matches
	 */
    public function __construct(User $user, Collection $matches)
    {
    	$this->user = $user;
        $this->matches = $matches;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
    	if($this->user->user_type === UserAccountType::BROKER) {
			$subject = 'Realtors in your market seeking lender connections';
		} else if ($this->user->user_type === UserAccountType::REALTOR) {
			$subject = 'Lenders in your market seeking realtor connections';
		}
        return $this->from(config('mail.from.address'))
			->subject($subject)
			->markdown('email.matching.suggested-matches', [
				'user'		=> $this->user,
				'matches'	=> $this->matches,
				'subject'	=> $subject,
			]);
    }
}
