<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewUserAdminNotification extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var User
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "New User Admin Notification";
        if($this->user->user_type == "broker"){
            $subject = "New Lender Registered On Render";
        }else if($this->user->user_type == "realtor"){
            $subject = "New Real Estate Agent Registered On Render";
        }
        return $this->from(config('mail.from.address'))
            ->subject($subject)
            ->markdown('email.auth.new-user-admin-notification');
    }
}
