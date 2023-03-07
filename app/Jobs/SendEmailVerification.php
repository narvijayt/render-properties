<?php

namespace App\Jobs;

use App\Mail\EmailVerification;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmailVerification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	/**
	 * @var User
	 */
	private $user;

	/**
	 * SendEmailVerification constructor.
	 *
	 * @param User $user
	 */
    public function __construct(User $user)
    {
		$this->user = $user;
	}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		$email = new EmailVerification($this->user);
		\Mail::to($this->user->email)->send($email);
    }
}
