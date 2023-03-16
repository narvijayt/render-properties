<?php

namespace App\Mail\Reviews;

use App\Review;
use App\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RejectOverridden extends Mailable
{
    use Queueable, SerializesModels;
    public $review;
    public $overrideMessage;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Review $review, String $overrideMessage)
    {
        $this->review = $review;
        $this->overrideMessage = $overrideMessage;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'))
            ->markdown('email.reviews.reject-overridden-to-subject');
    }
}