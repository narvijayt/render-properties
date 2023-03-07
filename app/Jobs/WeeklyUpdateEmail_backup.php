<?php

namespace App\Jobs;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class WeeklyUpdateEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	/**
	 * @var User
	 */
	private $user;
	/**
	 * @var integer
	 */
	private $matches;

	/**
	 * @var integer
	 */
	private $unreadCount;

	/**
	 * @var integer
	 */
	private $areaUsers;

	/**
	 * @var integer
	 */
	private $newAreaUsers;

	/**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $matches, $unreadCount, $areaUsers, $newAreaUsers)
    {
		$this->user = $user;
		$this->matches = $matches;
		$this->unreadCount = $unreadCount;
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
        $email = new \App\Mail\WeeklyUpdateEmail($this->user, $this->matches, $this->unreadCount, $this->areaUsers, $this->newAreaUsers);

        \Mail::to($this->user->email)
			->send($email);
    }
}
