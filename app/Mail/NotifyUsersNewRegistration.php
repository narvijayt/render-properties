<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class NotifyUsersNewRegistration extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public $user;
    
    /**
     * @var User
     */
    public $member;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, User $member)
    {
        //
        $this->user = $user;
        $this->member = $member;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->user->user_type == "vendor"){
            $usertype = 'Vendor';
        }elseif($this->user->user_type == "broker"){
            $usertype = 'Loan Officer';
        }elseif($this->user->user_type == "realtor"){
            $usertype = 'Realtor';
        }

        if($this->member->user_type == "vendor"){
            $memberType = 'Vendor';
        }elseif($this->member->user_type == "broker"){
            $memberType = 'Loan Officer';
        }elseif($this->member->user_type == "realtor"){
            $memberType = 'Realtor';
        }
        return $this->from(config('mail.from.address'))
            ->subject("New Member Alert - Connect with More Home Buyers and Sellers!")
            ->markdown('email.matching.new-user-register-notification', compact('usertype', 'memberType'));
    }
}
