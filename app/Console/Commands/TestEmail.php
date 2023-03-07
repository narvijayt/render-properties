<?php

namespace App\Console\Commands;

use App\Jobs\SendTestEmail;
use Illuminate\Console\Command;
use Mail;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {email} {--n=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Test Email to specified address';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	$count = (int) $this->option('n');
    	$progress = $this->output->createProgressBar($count);
    	for ($i = 0; $i < $count; $i++) {
    		$job = new SendTestEmail($this->argument('email'));
			dispatch($job);
			$progress->advance();
		}
		$progress->finish();

        $this->info('Message sent to: '.$this->argument('email'));
    }
}
