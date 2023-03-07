<?php

namespace App\Policies;

use App\Review;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy
{
    use HandlesAuthorization;
    use HandlesBouncerAuth;

    /**
     * Return model class for policy;
     * @return string
     */
    protected function policyModel(): string
    {
        return User::class;
    }

    /**
     * Determine if the currently authed user is the subject of a review
     *
     * @param User $user
     * @param Review $review
     * @return boolean
     */
    public function isSubject(User $user, Review $review)
    {
        return (
            $this->isLoggedIn() === true
            && ($user->user_id === ($review->subject_user_id)) === true
        );
    }

    /**
     * Determine if the currently authed user is the author of a review
     *
     * @param User $user
     * @param Review $review
     * @return boolean
     */
    public function isReviewer(User $user, Review $review)
    {
        return (
            $this->isLoggedIn() === true
            && ($user->user_id === ($review->reviewer_user_id)) === true
        );
    }




}
