<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Carbon\Carbon;
use App\Jobs\LenderMembership;
use App\Mail\LenderUpgrade;
use Symfony\Component\Console\Output\ConsoleOutput;

class LenderPatiniumMembership extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lender-platinium:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a report for all unpaid lenders users  after 2020 for each tuesday 10:00am for 2 months.';

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
     $lender = User::query()
			->where('user_type', 'broker')
			->whereNull('braintree_id')
			->whereNull('billing_first_name')
			->whereDate('created_at', '>=', '2020-01-01 00:00:00')
			->get()
			->filter(function(User $user) {
				return !$user->isPayingCustomer();
			});
		$i =1;
        foreach($lender as $lenderUnpaid){
       // if($i <=1){
       $findLender =  User::where('user_id','=',$lenderUnpaid->user_id)->get();
        $file = weekly_csv($findLender);
        $mail = new LenderUpgrade($file,'new-registered-users-till',$findLender);
          try{
           // \Mail::to('priya.negi60degreedigital@gmail.com')->bcc(['jacksmithjs1431@gmail.com'])->send($mail);
             
            \Mail::to($findLender[0]->email)->bcc(['james@realbrokerconnections.com'])->send($mail);
             sleep(3);
                //\Mail::to('nv@culture-red.com')->cc(['narvijay.thakur@gmail.com'])->send($mail);
                $this->output = new ConsoleOutput;
                $this->info("$i) Report Generated and sent to:".$findLender[0]->email);
            }
            catch(\Exception $e) {
                $this->info('Failed:'.$findLender[0]->email);
                \Log::error("$i) Failed Weekly premium membership Update: " . $e->getMessage());
                return ;
            }
            
        \Log::info("report generation ended   \r\n");
        $i++;
          //  }
    }
    }
    
    
}
