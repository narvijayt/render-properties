<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class AccountEnable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:account-enable {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enable an account for a specific user';

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
        //
        $user = User::where('email', $this->argument('email'))->first();
        $user->active = true;
        $user->save();

        $email = $user->email;

        $this->info("${email} has been enabled.");
    }
}
