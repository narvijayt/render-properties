<?php

namespace App\Http\Controllers\Pub;

use App\Policies\ReviewPolicy;
use DB;
use App\Enums\ReviewStatusType;
use App\Review;
use App\User;
use PDOException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;
use Silber\Bouncer\Bouncer;


class ReviewsController extends Controller
{
    /**
     * Shows the currently logged on persons reviews
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::User();
        $reviews = $user->reviews()->where('status', '!=', ReviewStatusType::REJECTED)->get();

        return view('pub.reviews.index',compact('reviews', 'user'));
    }

    /**
     * Shows the user who is clicked on's Reviews
     *
     * @param int $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function UserIndex(int $user_id)
    {
        $user = User::findOrFail($user_id);
        $reviews = $user->reviews()->where('status', '!=', ReviewStatusType::REJECTED)->get();
        return view('pub.reviews.users-index',compact('reviews', 'user'));
    }

    /**
     * Creates a Review the request comes from a modal
     */
    public function create()
    {
        try {
            $currentUserId = Auth::User()->user_id;
            $review = Review::create([
                'review_id' => Uuid::uuid4(),
                'message' => request()->reviewMessage,
                'rating' => request()->reviewRating,
                'status' => ReviewStatusType::UNSEEN,
                'created_at' => new \DateTime(),
                'reviewer_user_id' => $currentUserId,
                'subject_user_id' => (int)request()->user_id,

            ]);
            /**@param Review $review */
            $review->newReviewEmail();
            flash()->success("Review Successfully Sent");
            return redirect()->back();
        }
        catch(PDOException $e) {
            if ($e->getCode() == 23505){
                flash()->error("You have already reviewed this person.");
                return redirect()->back();
            }else{
                flash()->error("We encountered an Error Sending your review please try again later if the problem persists contact us in the link below.");
                return redirect()->back();
            }
        }
    }

    /**
     * Deletes the Review should only be accessed by Admin Email
     *
     * @param Review $review
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Review $review)
    {

        Auth::user()->isAn('Admin');
        $review->delete();
        flash()->success("Review Successfully Deleted");
        return redirect(Route('pub.reviews.your'));
    }

    /**
     * Returns the Get for overriding a Review
     *
     * @param Review $review
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function override(Review $review)
    {
        Auth::user()->isAn('Admin');
        return view('pub.reviews.override', compact('review'));
    }

    /**
     * Requires the Override message from the admin that is overriding the rejection
     *
     * @param Review $review
     * @param string $overrideMessage
     * @return \Illuminate\Http\RedirectResponse
     */
    public function overrideSubmit(Review $review)
    {
        Auth::user()->isAn('Admin');
        $review->override(request()->override_message);
        flash()->success("Review was Overridden");
        return redirect(Route('pub.reviews.your'));
    }

    /**
     * Accepts the Review should only be accessed by the subject user
     *
     * @param Review $review
     * @return \Illuminate\Http\RedirectResponse
     */
    public function accept(Review $review)
    {
        $this->authorize('isSubject', $review);
        $review->accept();
        flash()->success("Review Successfully Accepted");

        return redirect(Route('pub.reviews.your'));
    }

    /**
     * Shows review and view has a form for reject message.
     * @param Review $review
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reject(Review $review)
    {
        $this->authorize('isSubject', $review);

        return view('pub.reviews.reject', compact('review'));
    }

    /**
     * Post function for reject
     * Redirects to home
     *
     * @param Review $review
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */

    public function rejectSubmit(Review $review)
    {
        $this->authorize('isSubject', $review);
        $review->reject(request()->reject_message);
        flash()->success("Review Successfully Rejected");

        return redirect(Route('pub.reviews.your'));
    }

    /**
     * Shows View to edit a Review should only be shown to the reviewer
     *
     * @param Review $review
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Review $review)
    {
        $this->authorize('isReviewer', $review);

        return view('pub.reviews.edit', compact('review'));
    }

    /**
     * Post action for editing a review
     *
     * @param Review $review
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function editSubmit(Review $review)
    {
        $this->authorize('isReviewer', $review);
        $review->edit(request()->reviewMessage, request()->reviewRating);
        flash()->success("Review Edited!");

        return redirect(Route('pub.reviews.your'));

    }
}
