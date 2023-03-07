<?php

namespace App\Jobs;

use App\Mail\ReportsNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	/**
	 * @var string
	 */
	private $file;

	/**
	 * @var string
	 */
	private $name;

	/**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file, $name)
    {
        //
		$this->file = $file;
		$this->name = $name;
	}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		$mail = new ReportsNotification($this->file, $this->name);
	
    }
}
