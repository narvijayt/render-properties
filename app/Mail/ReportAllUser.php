<?php

namespace App\Mail;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReportAllUser extends Mailable
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
    public function __construct($report, $name = 'untitled-report',$totalRegUser)
    {
        $this->report = $report;
        $this->name = $name;
        $this->total_users = $totalRegUser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.reports.report', ['title' => 'List of All Users',
         'total_users' => $this->total_users])->subject('List of All Users.')->attachData($this->report, $this->name.'.csv', ['mime' => 'text/csv',]);
    }
}
