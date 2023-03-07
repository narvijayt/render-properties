<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Category;
use Carbon\Carbon;
use App\Jobs\VendorMembership;
use App\Mail\VendorUpgrade;
use Symfony\Component\Console\Output\ConsoleOutput;

class VendorPlatiniumMembership extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vendor-platinium:cron';

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
        $vendor = User::where('user_type','=','vendor')->whereNull('billing_first_name')->whereNull('braintree_id')->get();
        $i =1;
        foreach($vendor as $vendorunpaid)
        {
        // if($i <=1){
        $category = Category::where('user_id','=',$vendorunpaid->user_id)->whereNull('braintree_id')->get();
        if($category->isNotEmpty())
        {
             foreach($category as $categoryData)
             {   
                 $vendordata = User::where('user_id','=',$categoryData->user_id)->get();
                $file = weekly_csv($vendordata);
                $mail = new VendorUpgrade($file,'unpaid-vendors',$vendordata);
          try{
                //\Mail::to('priya.negi60degreedigital@gmail.com')->bcc(['jacksmithjs1431@gmail.com'])->send($mail);
                //\Mail::to('nv@culture-red.com')->cc(['narvijay.thakur@gmail.com'])->send($mail);
                \Mail::to($vendordata[0]->email)->cc(['james@realbrokerconnections.com'])->send($mail);
                 sleep(3);
                $this->output = new ConsoleOutput;
                $this->info("$i) Report Generated and sent to:".$vendordata[0]->email);
            }
            catch(\Exception $e) {
                \Log::error("$i) Failed vendor : " . $e->getMessage());
                return ;
            }
             \Log::error("$i) Weekly premium membership Update : " . $vendordata[0]->email);
        \Log::info("report generation ended   \r\n");
          }
        }else{
            $vendordata = User::where('user_id','=',$vendorunpaid->user_id)->get();
            $file = weekly_csv($vendordata);
                $mail = new VendorUpgrade($file,'unpaid-vendors',$vendordata);
          try{
                //\Mail::to('priya.negi60degreedigital@gmail.com')->bcc(['jacksmithjs1431@gmail.com'])->send($mail);
                //\Mail::to('nv@culture-red.com')->cc(['narvijay.thakur@gmail.com'])->send($mail);
                \Mail::to($vendordata[0]->email)->cc(['james@realbrokerconnections.com'])->send($mail);
                sleep(3);
                $this->output = new ConsoleOutput;
                $this->info("$i) Report Generated and sent to:".$vendordata[0]->email);
            }
            catch(\Exception $e) {
                \Log::error("$i) Failed vendor : " . $e->getMessage());
                return ;
            }
             \Log::error("$i) Weekly premium membership Update : " . $vendordata[0]->email);
             \Log::info("report generation ended   \r\n");
            }
          $i++;
        //}
        }
    }
    
    
}
