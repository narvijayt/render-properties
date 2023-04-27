<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Carbon\Carbon;
use App\Jobs\WeeklyRegistedUsers;
use App\Mail\weeklyRegisteredUsers;
use Symfony\Component\Console\Output\ConsoleOutput;

class ReportNewUsersListEveryFriday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'registeredtillfriday:users_list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a report for all new users till friday for each week.';

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
        \Log::info("weekly report \r\n");
        $dateStr = date('Y-m-d', strtotime('last friday'));//previous friday
        $cominSat = Carbon::parse('this saturday')->toDateString();//coming friday
        $users = User::where('created_at', '>=', $dateStr)->with('checkuser_with_unmatch')
        ->where('created_at', '<', $cominSat)->orderBy('created_at', 'asc')
        ->get();
        $totalRegUser = 0;
            if(count($users) > 0){
                $totalRegUser = count($users);
            }
        $file = weekly_csv($users);
        $mail = new weeklyRegisteredUsers($file, 'new-registered-users-till',$totalRegUser);
            try{
                \Mail::to('richard@realbrokerconnections.com')->cc(['membership@realbrokerconnections.com','richardtocado@gmail.com','nv@culture-red.com','ty@culture-red.com','james@realbrokerconnections.com','lindsay@realbrokerconnections.com','derek@realbrokerconnections.com','marketing@render.properties'])->send($mail);
                // \Mail::to('amit@culture-red.com')->send($mail);
                // \Mail::to('jacksmithjs1431@gmail.com')->cc(['priya.negi60degreedigital@gmail.com'])->send($mail);
                $this->output = new ConsoleOutput;
                $this->info('Report Generated and sent to: '.config('mail.send_to_addresses.reports'));
            }
            catch(\Exception $e) {
                \Log::error("Weekly report for new user registration errored with response : " . $e->getMessage());
                return ;
            }
        \Log::info("report generation ended   \r\n");
    }
}
