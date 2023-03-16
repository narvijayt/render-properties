<?php

namespace App\Mail\Matching;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\User;

class NewMatchSuccess extends Mailable
{
    use Queueable, SerializesModels;

	/**
	 * @var User
	 */
    protected $toUser;

	/**
	 * @var User
	 */
    protected $fromUser;

	/**
	 * NewMatchSuccess constructor.
	 *
	 * @param User $to
	 * @param User $from
	 */
    public function __construct(User $to, User $from)
    {
        $this->toUser = $to;
        $this->fromUser = $from;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Match Success!')
            ->from(config('mail.from.address'))
			->markdown('email.matching.new-success', [
				'to' => $this->toUser,
				'from' => $this->fromUser,
			]);
    }
}
