<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\BuySellProperty;

class LeadNotification extends Mailable
{
    use Queueable, SerializesModels;
    protected $formDetails;
    public $email_type;
    public $subject;
    public $username;
    public $completeShortURL;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($formId, $email_type, $recipient_name, $completeShortURL)
    {
        // dd($email_type);
        $this->formDetails = BuySellProperty::find($formId);
        $this->email_type = $email_type;
        $this->username = $recipient_name;
        $this->completeShortURL = $completeShortURL;
        $this->subject = "Lead: ". $this->formDetails->firstName ." " . $this->formDetails->lastName . " wants to " . $this->formDetails->formPropertyType . " property";
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), 'Render')
                    ->subject($this->subject)
                    ->markdown('email.lead-notification', [
                        'formDetails' => $this->formDetails,
                        'email_type' => $this->email_type,
                        'user_name' => $this->username,
                        'short_url' => $this->completeShortURL,
                    ])
                    ->withSwiftMessage(function ($message) {
                        \Log::info($message->toString());
                    });

    }

}
