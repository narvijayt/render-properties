<?php

namespace App\Console\Commands;

use App\Jobs\SendReport;
use App\User;
use App\Mail\ReportsNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Output\ConsoleOutput;


class ReportNewUsers extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'reports:new-users';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generates a report for all new users within the last 24hrs.';

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
        \Log::info("everyday");
        $start = Carbon::yesterday();
        $end = Carbon::today();
        $users = User::where('created_at', '>=', $start)
        	->where('created_at', '<', $end)->orderBy('created_at', 'asc')->with('checkuser_with_unmatch')
        	->get();
        	$totalUsers = 0;
        	if(count($users) > 0){
                $totalUsers = count($users);
        	}
        $file = bulider_csv($users);
        $mail = new ReportsNotification($file, 'new-user-report',$totalUsers);
        \Mail::to('richard@realbrokerconnections.com')->cc(['membership@realbrokerconnections.com','richardtocado@gmail.com','nv@culture-red.com','ty@culture-red.com','james@realbrokerconnections.com','lindsay@realbrokerconnections.com','derek@realbrokerconnections.com'])->send($mail);
        // \Mail::to('amit@culture-red.com')->send($mail);
         //\Mail::to('jacksmithjs1431@gmail.com')->cc(['priya.negi60degreedigital@gmail.com'])->send($mail);
        $this->output = new ConsoleOutput;
        $this->info($totalUsers.'Report Generated and sent to : '.config('mail.send_to_addresses.reports'));
	}
}
