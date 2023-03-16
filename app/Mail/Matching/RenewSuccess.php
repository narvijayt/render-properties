<?php

namespace App\Mail\Matching;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RenewSuccess extends Mailable
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
	 * RenewSuccess constructor.
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
        return $this->subject('Match Renewal Success')
            ->from(config('mail.from.address'))
			->markdown('email.matching.renew-success', [
				'toUser' => $this->toUser,
				'fromUser' => $this->fromUser,
			]);
    }
}
