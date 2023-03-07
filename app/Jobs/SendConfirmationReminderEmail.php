<?php

namespace App\Jobs;

use App\Mail\ConfirmationReminderEmail;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendConfirmationReminderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	/**
	 * @var User
	 */
	private $user;

	/**
	 * @var integers
	 */
	private $areaUsers;

	/**
	 * @var integers
	 */
	private $newAreaUsers;

	/**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $areaUsers, $newAreaUsers)
    {
        //
		$this->user = $user;
		$this->areaUsers = $areaUsers;
		$this->newAreaUsers = $newAreaUsers;
	}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mail = new ConfirmationReminderEmail($this->user, $this->areaUsers, $this->newAreaUsers);

        \Mail::to($this->user->email)
			->send($mail);
    }
}
