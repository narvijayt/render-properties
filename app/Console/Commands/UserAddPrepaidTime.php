<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class UserAddPrepaidTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:add-prepaid-time {email : The email address for the user} {--months=1 : The number of months to add to the account}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add prepaid time to a users account ';

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
		$duration = (int) $this->option('months');
		$email = $this->argument('email');

		$user = User::whereEmail($email)->firstOrFail();
		$user->addPrepaidTime($duration);
    }
}
