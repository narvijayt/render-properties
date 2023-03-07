<?php

namespace App\Mail;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class weeklyRegisteredUsers extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($report, $name = 'week-report',$totalUsers)
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
        $ddate = new \DateTime($date);
        $week = $ddate->format("W");
        return $this->markdown('email.auth.register-user-till-friday', [
        'title' => 'List Of New Users Registered For (Week '.$week.') Till -'.' ('.$date->format('jS M, Y') .')',
        'total_users' => $this->total_users
        ])
            ->subject('New Users Registered This Week, - week '.$week)
        ->attachData($this->report, $this->name.'-'.$date->format('d-M-Y').'.csv', [
        'mime' => 'text/csv',
        ]);
    }
}
