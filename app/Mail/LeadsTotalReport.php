<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class LeadsTotalReport extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($forms)
    {
        $this->forms = (array) json_decode($forms, true);

        $this->buy_property_count = $this->forms['buy']['totalLeads'];
        $this->sell_property_count = $this->forms['sell']['totalLeads'];
        $this->refinance_count = $this->forms['refinance']['totalLeads'];
        $this->all_type_leads_count = $this->forms['total'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $date = Carbon::today();

        $email = $this->markdown('email.reports.leads-total', [
            'buy_property_count' => $this->buy_property_count,
            'sell_property_count' => $this->sell_property_count,
            'refinance_count' => $this->refinance_count,
            'all_type_leads_count' => $this->all_type_leads_count,
        ])
        ->subject('Total Leads Received');

        $csvFiles = [
            [
                'report' => $this->forms['buy']['file'],
                'name' => $this->forms['buy']['fileName'],
            ],
            [
                'report' => $this->forms['sell']['file'],
                'name' => $this->forms['sell']['fileName'],
            ],
            [
                'report' => $this->forms['refinance']['file'],
                'name' => $this->forms['refinance']['fileName'],
            ],
        ];

        foreach ($csvFiles as $value) {
            $email->attachData($value['report'], $value['name'].'-'.$date->format('d-M-Y').'.csv', [
                'mime' => 'text/csv',
            ]);
        }

        return $email;
    }
}
