<?php
/**
 * Created by PhpStorm.
 * User: lanebandli
 * Date: 8/24/17
 * Time: 9:11 AM
 */
namespace App;

use App\Mail\Reviews\EditedReview;
use App\Mail\Reviews\NewReview;
use App\Mail\Reviews\RejectOverridden;
use Mail;
use App\Enums\ReviewStatusType;
use App\Mail\Reviews\RejectToAdmin;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use Ramsey\Uuid\Uuid;

class Review extends Model
{
    use SoftDeletes;

    const PKEY = 'review_id';

    protected $primaryKey = self::PKEY;

    public $incrementing = false;

    protected $fillable = [
        'review_id',
        'reviewer_user_id',
        'subject_user_id',
        'reject_message',
        'message',
        'rating',
        'status',
        'created_at',
        'rejected_at',
        'delete_at'
    ];

    protected $casts = [
        'reviewer_user_id' => 'int',
        'subject_user_id' => 'int',
        'rating' => 'int',
    ];

    protected $dates = [
        'deleted_at',
    ];
    /**
     * Get the user who wrote the review
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_user_id', 'user_id');
    }

    /**
     * returns the full name of the reviewer
     *
     * @return string
     */
    public function reviewerFullName()
    {
        return $this->reviewer->full_name();
    }

    /**
     * Get the user who is the subject of the review
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subject()
    {
        return $this->belongsTo(User::class, 'subject_user_id', 'user_id');
    }

    /**
     * Returns the full name of the subject of the
     * review
     *
     * @return string
     */
    public function subjectFullName()
    {
        return $this->subject->full_name();
    }

    /**
     *  Accepts the review
     */
    public function accept()
    {
        $this->update([
            'status' => ReviewStatusType::ACCEPTED,
        ]);
    }

    /**
     * Overrides a previously rejected message and sends an email explaining why to the subject who
     * rejected it
     *
     * @param $override_message
     */
    public function override($override_message)
    {
        $this->update([
            'status' => ReviewStatusType::OVERRIDDEN,
        ]);

        $this->rejectOverriddenEmail($override_message);

    }

    /**
     * Changes the status to rejected and sends an email to an admin
     *
     * @param Review $review
     * @param $reject_message
     */
    public function reject($reject_message)
    {
        $this->update([
            'status'            => ReviewStatusType::REJECTED,
            'reject_message'    => $reject_message,
            'rejected_at'       => new \DateTime()
        ]);
        $this->rejectToAdminEmail();
    }

    /**
     * Edits the review to the new content user inputs
     *
     * @param $Message
     * @param $rating
     */
    public function edit($Message, $rating)
    {
        $this->update([
            'status'    => ReviewStatusType::UNSEEN,
            'message'   => $Message,
            'rating'    => $rating,
        ]);
        $this->reviewEditedEmail();
    }

    /**
     * Sends the email to admin when a rejection comes in
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rejectToAdminEmail()
    {
        $email = new RejectToAdmin($this);
        Mail::to(config('app.admin_email'))->send($email);
        return back();
    }

    /**
     * Creates the Email sent to users' who rejected a review and the reject got overridden
     *
     * @param String $overrideMessage
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rejectOverriddenEmail(String $overrideMessage)
    {
        try
        {
        	if ($this->subject->settings->email_receive_review_messages) {
				$email = new RejectOverridden($this, $overrideMessage);
				Mail::to(User::find($this->subject_user_id)->email)->send($email);
			}

            return back();
        }
        catch(Exception $e)
        {
            DB::rollback();
            return back();
        }
    }

    /**
     * Notifies the user of a new review on them
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function newReviewEmail()
    {
        try
        {
			if ($this->subject->settings->email_receive_review_messages) {
				// After creating the user send an email with the random token generated in the create method above
				$email = new NewReview($this);
				Mail::to(User::find($this->subject_user_id)->email)->send($email);
			}

            return back();
        }
        catch(Exception $e)
        {
            DB::rollback();
            return back();
        }
    }

    /**
     * Returns a reviews ID
     *
     * @return Uuid
     */
    public function review_id()
    {
        return $this->review_id;
    }

    /**
     * Creates an email that notifies a subject of an edited review
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reviewEditedEmail()
    {
        try
        {
			if ($this->subject->settings->email_receive_review_messages) {
				// After creating the user send an email with the random token generated in the create method above
				$email = new EditedReview($this);
				Mail::to(User::find($this->subject_user_id)->email)->send($email);
			}

            return back();
        }
        catch(Exception $e)
        {
            DB::rollback();
            return back();
        }
    }

}