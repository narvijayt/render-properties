<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;
use App\Mail\TestEmail;

class SendTestEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	/**
	 * @var string
	 */
	private $address;

	/**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $address)
    {
        //
		$this->address = $address;
	}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		Mail::to($this->address)
			->send(new TestEmail());//
    }
}
