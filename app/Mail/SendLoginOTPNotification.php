<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendLoginOTPNotification extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * @var User
     */
    public $user;

    /**
     * @var User
     */
    public $otp_code;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $User, $otp_code)
    {
        //
        $this->user = $User;
        $this->otp_code = $otp_code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
        return $this->subject("Render: OTP to Login")
            ->markdown('email.login-otp');
    }
}
