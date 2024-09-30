<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;

class ReportLeadsTotal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:leads-total';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Report total count of leads till now';

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
        // Get leads
        $buy_property =  \App\BuySellProperty::where('formPropertyType', '=', 'buy')->orderBy('created_at', 'asc')->get();
        $sell_property =  \App\BuySellProperty::where('formPropertyType', '=', 'sell')->orderBy('created_at', 'asc')->get();
        $refinance =  \App\Refinance::orderBy('created_at', 'asc')->get();

        // Get leads count
        $buy_property_count =  $buy_property->count();
        $sell_property_count =  $sell_property->count();
        $refinance_count =  $refinance->count();
        
        $all_type_leads_count = (int) $buy_property_count + (int) $sell_property_count + (int) $refinance_count;
        
        $buy_property_lead_file = leads_csv_builder($buy_property, "buy");
        $sell_property_lead_file = leads_csv_builder($sell_property, "sell");
        $refinance_lead_file = leads_csv_builder($refinance, "refinance");
        
        $forms = [
            "buy" => [
                "file" => $buy_property_lead_file,
                "fileName" => "buy-property-lead-report",
                "totalLeads" => $buy_property_count
            ],
            "sell" => [
                "file" => $sell_property_lead_file,
                "fileName" => "sell-property-lead-report",
                "totalLeads" => $sell_property_count
            ],
            "refinance" => [
                "file" => $refinance_lead_file,
                "fileName" => "refinance-lead-report",
                "totalLeads" => $refinance_count
            ],
            "total" => $all_type_leads_count
        ];

        $forms = json_encode($forms, true);
        
        $mail = new \App\Mail\LeadsTotalReport($forms);        

        if (env('APP_ENV') != "local") {
            Mail::to(['richardtocado@gmail.com'])->cc(['nv@culture-red.com', 'iamabhaykumar2002@gmail.com'])->send($mail);
        }
    }
}
