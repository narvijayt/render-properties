<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class LeadsReport extends Mailable
{
    use Queueable, SerializesModels;
    protected $report;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($report, $name, $formTitle, $totalLeads)
    {
        $this->report = $report;
        $this->name = $name;
        $this->formTitle = $formTitle;
        $this->total_leads = $totalLeads;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $date = Carbon::now();
        $yesterday = Carbon::yesterday();
        return $this->markdown('email.reports.leads', [
                'title' => $this->formTitle.' Leads Received Yesterday - '.$yesterday->format('jS M, Y'),
                'total_leads' => $this->total_leads
            ])
            ->subject($this->formTitle.' Leads Received Yesterday - '.$yesterday->format('jS M, Y'))
            ->attachData($this->report, $this->name.'-'.$yesterday->format('d-M-Y').'.csv', [
				'mime' => 'text/csv',
            ]);
    }
}
