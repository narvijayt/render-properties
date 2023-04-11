<?php

namespace App\Console\Commands;
use App\User;
use App\Jobs\SendReport;
use App\Mail\ReportAllUser;
use Illuminate\Console\Command;
use Symfony\Component\Console\Output\ConsoleOutput;

class ReportAllUsers extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'reports:all-users';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generates a report for all users';

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
	 \Log::info("all users");
	 ini_set('memory_limit', '2048M');
	   $users = User::where('email','!=','admin@realbrokerconnection.com')->orderBy('created_at', 'asc')->with('checkuser_with_unmatch')->get();
	   $file = bulider_csv($users);
	    $totalRegUser = 0;
            if(count($users) > 0){
                $totalRegUser = count($users);
            }
            $mail = new ReportAllUser($file, 'all-users-report',$totalRegUser);
            \Mail::to('richard@realbrokerconnections.com')->cc(['membership@realbrokerconnections.com','richardtocado@gmail.com','nv@culture-red.com','ty@culture-red.com','james@realbrokerconnections.com','lindsay@realbrokerconnections.com','derek@realbrokerconnections.com'])->send($mail);
            // \Mail::to('amit@culture-red.com')->send($mail);
             //\Mail::to('jacksmithjs1431@gmail.com')->cc(['priya.negi60degreedigital@gmail.com'])->send($mail);
            $this->output = new ConsoleOutput;
            $this->info('Report Generated and sent to: '.config('mail.send_to_addresses.reports'));
   	}
}
