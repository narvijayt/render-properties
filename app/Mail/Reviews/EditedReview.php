<?php

namespace App\Mail\Reviews;

use App\Review;
use App\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EditedReview extends Mailable
{
    use Queueable, SerializesModels;
    public $review;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Review $review)
    {
        $this->review = $review;
        $this->user = User::findOrFail($review->reviewer_user_id);

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
            ->markdown('email.reviews.edited-review');
    }
}