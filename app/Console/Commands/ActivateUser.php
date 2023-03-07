<?php

namespace App\Console\Commands;

use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ActivateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:activate-user {email} {--D|duration=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Activate a user for a defined period of time';

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
    	$duration = 30;

    	if ($this->option('duration') !== null){
    		$duration = $this->option('duration');
		}

		$endDate = Carbon::now()->addDays($duration);

    	$user = User::where('email', $this->argument('email'))->first();
    	$users = User::whereNotNull('email')->get();

    	$user->prepaid_period_ends_at = $endDate;
    	$user->save();

    	$email = $user->email;

    	$this->info("Activated ${email} for ${duration} days");
    }
}
