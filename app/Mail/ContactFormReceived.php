<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormReceived extends Mailable
{
    use Queueable, SerializesModels;

	/**
	 * @var object
	 */
    protected $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
   return $this->from(config('mail.from.address'), config('mail.from.name'))
			->to([config('app.support_email')])
			->cc('richard@realbrokerconnections.com','james@realbrokerconnections.com','richardtocado@gmail.com','nv@culture-red.com')
            ->bcc('nv@culture-red.com')
            ->subject('Contact Form Submission: '.$this->message->subject)
			->markdown('email.contact-form.received', [
				'message' => $this->message,
			]);
    }
}
