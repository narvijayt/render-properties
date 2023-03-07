<?php

namespace App\Mail;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LenderUpgrade extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($report,$name = 'week-report',$lender)
    {
       $this->report = $report;
       $this->name = $name;
        $this->users = $lender;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         return $this->markdown('email.auth.lender-platinium-membership', [
        'title' => 'Lender Platinum Membership Special Offer!',
        'users' => $this->users
        ])
            ->subject('LAST CHANCE - Platinum Membership Special Offer!');
        /*->attachData($this->report, $this->name.'.csv', [
        'mime' => 'text/csv',
        ]);*/
    }
}
