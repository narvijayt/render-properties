<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Refinance;
use App\Mail\LeadsReport;
use App\BuySellProperty;
use Carbon\Carbon;
use Symfony\Component\Console\Output\ConsoleOutput;

class ReportNewLeads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:new-leads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a report for all new leads within the last 24hrs.';

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
        $start = Carbon::yesterday();
        $end = Carbon::today();
        
        $propertyLeads = BuySellProperty::where('created_at', '>=', $start)->where('created_at', '<', $end)->orderBy('created_at', 'asc')->get();
        $refinanceLeads = Refinance::where('created_at', '>=', $start)->where('created_at', '<', $end)->orderBy('created_at', 'asc')->get();
        
        $buyerLeads = $propertyLeads->where('formPropertyType', 'buy');
        $sellerLeads = $propertyLeads->where('formPropertyType', 'sell');

        $totalBuyPropertyLeads = 0;
        $totalSellPropertyLeads = 0;
        $totalRefinanceLeads = 0;

        if(count($buyerLeads) > 0) {
            $totalBuyPropertyLeads = count($buyerLeads);
        }

        if(count($sellerLeads) > 0) {
            $totalSellPropertyLeads = count($sellerLeads);
        }

        if(count($totalRefinanceLeads) > 0) {
            $totalRefinanceLeads = count($refinanceLeads);
        }

        $buy_property_lead_file = leads_csv_builder($buyerLeads, "buy");
        $sell_property_lead_file = leads_csv_builder($sellerLeads, "sell");
        $refinance_lead_file = leads_csv_builder($refinanceLeads, "refinance");
        
        $forms = [
            "buy" => [
                "file" => $buy_property_lead_file,
                "fileName" => "buy-property-lead-report",
                "formTitle" => "Buy Property",
                "totalLeads" => $totalBuyPropertyLeads
            ],
            "sell" => [
                "file" => $sell_property_lead_file,
                "fileName" => "sell-property-lead-report",
                "formTitle" => "Sell Property",
                "totalLeads" => $totalSellPropertyLeads
            ],
            "refinance" => [
                "file" => $refinance_lead_file,
                "fileName" => "refinance-lead-report",
                "formTitle" => "Refinance",
                "totalLeads" => $totalRefinanceLeads
            ]
        ];

        foreach ($forms as $key => $data) {
            $mail = new LeadsReport($data["file"], $data["fileName"], $data["formTitle"], $data["totalLeads"]);
            if (env('APP_ENV') != "local") {
                \Mail::to(['richardtocado@gmail.com'])->cc(['nv@culture-red.com'])->send($mail);
            }

            $this->output = new ConsoleOutput;
            $this->info($data["totalLeads"].'Report Generated and sent to : '.config('mail.send_to_addresses.reports'));
        }
    }
}
