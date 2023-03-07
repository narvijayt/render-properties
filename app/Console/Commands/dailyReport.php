<?php

namespace App\Console\Commands;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class dailyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user_register:broker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check today register user type broker list';

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
        $start = Carbon::today();
        $users = User::where('created_at', '==', $start)->get();
        //$file = builder_user_report_csv($users);
    
    }
}
