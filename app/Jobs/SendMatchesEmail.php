<?php

namespace App\Jobs;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\Matching\MatchSuggestions;
use Illuminate\Support\Collection;
use Mail;

class SendMatchesEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	/**
	 * @var User
	 */
	private $user;
	/**
	 * @var Collection
	 */
	private $matches;

	/**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Collection $matches)
    {
		$this->user = $user;
		$this->matches = $matches;
	}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		$mail = new MatchSuggestions($this->user, $this->matches->shuffle());
		Mail::to($this->user->email)->send($mail);
    }
}
