<?php

use App\Review;
use App\Services\Review\ReviewService;
use Illuminate\Database\Seeder;
use App\Conversation;
use App\Message;
use Carbon\Carbon;
use App\User;

class ReviewsSeeder extends Seeder
{
    public function __construct(ReviewService $reviewService)
    {
        $this->ReviewService = $reviewService;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $realtors = User::realtors()->get();
        $brokers = User::brokers()->get();

        $brokers
            ->shuffle()
            ->each(function(User $owner) use ($realtors) {
                /** @var Review $review */
                /** @var User $contact */
                $contact = $realtors->random();
//                if(Review::query()->where(
//                    'subject_user_id' == $owner->user_id
//                    && 'reviewer_user_id' == $contact->user_id))
//                {}else {
                    factory(Review::class)->create([
                        'subject_user_id' => $owner->user_id,
                        'reviewer_user_id' => $contact->user_id,
                    ]);
//                }
            });

        $realtors
            ->shuffle()
            ->each(function(User $owner) use ($brokers) {
                /** @var Review $review */
                /** @var User $contact */
                $contact = $brokers->random();
                factory(Review::class)->create([
                    'subject_user_id' => $owner->user_id,
                    'reviewer_user_id' => $contact->user_id,
                ]);
            });
    }

    /**
     * Attach the user to the review as the subject
     * s
     * @param Review $review
     * @param User $user
     */
    public function attachSubjectToSubject(Review $review, User $user)
    {
        $review->update([
            'subject_user_id' => $user->user_id,
        ]);
    }

    /**
     * Attach the user to the review as the reviewer
     *
     * @param Review $review
     * @param User $user
     */
    public function attachReviewerToReview(Review $review, User $user)
    {
        $review->update([
            'reviewer_user_id' => $user->user_id,
        ]);
    }
}