<?php
namespace App\Services\Review;
use App\Review;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use App\User;
class ReviewService
{
    public function attachSubjectToReview(User $user, Review $review)
    {
        $review->update([
           'subject_user_id' => $user->user_id,
        ]);
    }

    public function attachReviewerToReview(User $user, Review $review)
    {
        $review->update([
           'reviewer_user_id' => $user->user_id,
        ]);
    }

    public function subjectFullName(Review $review)
    {
        $user1 = User::findOrFail($review->subject_user_id);
        return $user1->full_name();
    }

    public function reviewerFullName(Review $review)
    {
        $user1 = User::findOrFail($review->reviewer());
        return $user1->full_name();
    }

    public function userReviews(User $user)
    {
        return Review::query()->where('subject_user_id' == $user->user_id) ;
    }

}
