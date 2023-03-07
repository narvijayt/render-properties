<?php

namespace App\Console\Commands;

use App\Jobs\SendEmailVerification;
use App\User;
use Illuminate\Console\Command;
use Ramsey\Uuid\Uuid;

class ResendEmailVerification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-verification {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a verification email to a specified address';

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
    	$user = User::whereEmail($this->argument('email'))
			->firstOrFail();

    	if ($user->email_token === null) {
    		$user->email_token = Uuid::uuid4()->toString();
    		$user->save();
		}

    	dispatch(New SendEmailVerification($user));

    	$this->info('Sent verification email to: '.$user->email);

    }
}
