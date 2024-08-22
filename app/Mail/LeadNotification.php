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

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($formId)
    {
        // dd($formId);
        $this->formDetails = BuySellProperty::find($formId);
        // dd($this->formDetails);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), 'Render')
                    ->subject("New Leads!")
                    ->markdown('email.lead-notification', [
                        'formDetails' => $this->formDetails,
                    ])
                    ->withSwiftMessage(function ($message) {
                        \Log::info($message->toString());
                    });
    }

}
