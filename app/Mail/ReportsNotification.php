<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReportsNotification extends Mailable
{
    use Queueable, SerializesModels;

	/**
	 * @var resource
	 */
    protected $report;

	/**
	 * @var string
	 */
    protected $name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($report, $name = 'untitled-report',$totalUsers)
    {
        $this->report = $report;
        $this->name = $name;
        $this->total_users = $totalUsers;
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
        return $this->markdown('email.reports.report', [
             'title' => 'New Users Registered Yesterday - '.$yesterday->format('jS M, Y'),
             'total_users' => $this->total_users
        		])
        	 ->subject('New Users Registered Yesterday - '.$yesterday->format('jS M, Y'))
        	 ->attachData($this->report, $this->name.'-'.$yesterday->format('d-M-Y').'.csv', [
				'mime' => 'text/csv',
			]);
    }
}
