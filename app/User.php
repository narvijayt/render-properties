<?php

namespace App;

use App\Enums\MatchPurchaseType;
use App\Enums\UserAccountType;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use App\Enums\AvatarSizeEnum;
use App\Category;
use App\Payment;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;

use App\RealtorDetail;
use App\LenderDetail;
use App\VendorMeta;
use App\LeadNotificationRelationships;

class User extends Authenticatable implements ISecurable
{
	use Notifiable, HasRolesAndAbilities, Securable, Billable;

	const PKEY = 'user_id';
	protected $primaryKey = self::PKEY;

	protected $distanceQuery = "ST_DISTANCE(
			ST_POINT(?, ?)::geography,
			ST_POINT(longitude, latitude)::geography
		) / 1609.34";
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'active',
		'billing_address_1',
		'billing_address_2',
		'billing_company',
		'billing_first_name',
		'billing_last_name',
		'billing_locality',
		'billing_postal_code',
		'billing_region',
		'bio',
		'city',
		'email',
		'email_token',
		'firm_name',
		'first_name',
		'last_name',
		'lock_ts',
		'monthly_sales',
		'password',
		'phone_ext',
		'phone_number',
		'prepaid_period_ends_at',
		'prof_license',
		'register_ts',
		'state',
		'last_activity',
		'user_avatar_id',
		'user_type',
		'username',
		'verified',
		'verify_ts',
		'website',
		'years_of_exp',
		'zip',
		'latitude',
		'longitude',
		'uid',
        'specialties',
        'license',
        'video_url',
        'postal_code_service',
        'units_closed_monthly',
        'volume_closed_monthly',
        'payment_transaction_id'

	];

	protected $dates = [
		'last_activity',
		'prepaid_period_ends_at',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
		'email_token',
		'verified',
	];

	public function getForeignKey()
	{
		return self::PKEY;
	}

	/**
	 * Set the currently active avatar for the user.
	 *
	 * @param UserAvatar $avatar
	 * @return User
	 */
	public function setAvatar(UserAvatar $avatar)
	{
		$this->user_avatar_id = $avatar->user_avatar_id;
		$this->save();

		return $this;
	}

	/**
	 * Get the users currently active avatar
	 *
	 * @return UserAvatar;
	 */
	public function getAvatar()
	{
		return $this->avatars()->find($this->user_avatar_id); //('user_avatar_id', $this->user_avatar_id)->first();
	}

	/**
	 * Limit result to users with the given active state
	 *
	 * @param Builder $query
	 * @param bool $active
	 *
	 * @return Builder
	 */
	public function scopeActive(Builder $query, bool $active = true) {
		return $query->where('active', $active);
	}
	/**
	 * Get the users avatar url
	 *
	 * @param string $size
	 *
	 * @return string
	 */
	public function avatarUrl(string $size = null)
	{
		$size = $size !== null ? $size : AvatarSizeEnum::LARGE;

		$avatar = $this->getAvatar();
		if ($avatar === null) {
		     $avatarImg = config('upload.user_avatar_avatar');
		    $randomDefaultImg = array_random($avatarImg);
			return url(config('app.url') . $randomDefaultImg);
		}

		return $this->getAvatar()->fullUrl($size);
	}

	/**
	 * Return a collection of all avatars owned by the user
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function avatars()
	{
		return $this->hasMany(UserAvatar::class, 'user_id');
	}

    public function categories()
	{
	    return $this->hasMany(Category::class, 'user_id');
	}
	
	
	public function vendor_details()
	{
	    return $this->hasMany(VendorDetails::class, 'user_id');
	}
	
	public function payment_details()
	{
	    return $this->hasMany(Payment::class,'user_id');
	}
	
	public function vendorPackage()
	{
	    return $this->hasOne(VendorPackages::class,'id','packageId');
	}
	
	
	/**
	 * Fetch related UserSetting record
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function settings()
	{
		$rel = $this->hasOne(UserSetting::class, User::PKEY)->withDefault([
			'user_id' => $this->user_id,
			'match_by_states' => [$this->state],
			'match_by_exp_min' => config('user_settings.match_by_exp_min'),
			'match_by_exp_max' => config('user_settings.match_by_exp_max'),
			'match_by_sales_total_min' => config('user_settings.match_by_sales_total_min'),
			'match_by_sales_total_max' => config('user_settings.match_by_sales_total_max'),
			'email_receive_match_requests' => config('user_settings.email_receive_match_requests'),
			'email_receive_match_suggestions' => config('user_settings.email_receive_match_suggestions'),
			'email_receive_review_messages' => config('user_settings.email_receive_review_messages'),
			'email_receive_weekly_update_email' => config('user_settings.email_receive_weekly_update_email'),
			'email_receive_conversation_messages' => config('user_settings.email_receive_conversation_messages'),
			'email_receive_email_confirmation_reminders' => config('user_settings.email_receive_email_confirmation_reminders'),
		]);

		return $rel;
	}

	/**
	 * Fetch Oauth Providers
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function providers()
	{
		return $this->hasMany(UserProvider::class, User::PKEY);
	}

	/**
	 * Fetch profile views for this users profile
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function profile_views()
	{
		return $this->hasMany(UserProfileView::class, User::PKEY);
	}
	
	public function banner_image()
	{
		return $this->hasMany(Banner::class, 'user_id');
	}


	/**
	 * Fetch this users views of others profiles
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function profile_views_external()
	{
		return $this->hasMany(UserProfileView::class, 'viewer_id');
	}

	/**
	 * Add a profile view to this user from the provided user
	 *
	 * @param User $viewer
	 */
	public function add_profile_view(User $viewer)
	{
		$this->profile_views()->create([
			'user_id'		=> $this->user_id,
			'viewer_id'		=> $viewer->user_id,
			'viewed_at'		=> Carbon::now(),
		]);
	}

	/**
	 * Add a profile view to another users profile
	 *
	 * @param User $viewee
	 */
	public function add_external_profile_view(User $viewee)
	{
		$this->profile_views()->create([
			'user_id'		=> $viewee->user_id,
			'viewer_id'		=> $this->user_id,
			'viewed_at'		=> Carbon::now(),
		]);
	}

	/**
	 * Fetches Full Name
	 *
	 * @return string
	 */
	public function full_name()
	{
		return $this->first_name.' '.$this->last_name;
	}

	/**
	 * Fetches all Sent Messages
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function sentMessages()
	{
		return $this->hasMany(Message::class, $this->primaryKey);
	}

	/**
	 * Fetches all initiated Matches
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function match_init()
	{
		return $this->hasMany(Match::class, Match::USER1);
	}

	/**
	 * Fetches all received Matches
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function match_with()
	{
		return $this->hasMany(Match::class, Match::USER2);
	}

	/**
	 * Fetches all Match results
	 *
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function matches()
	{
		$init = $this->match_init;
		$with = $this->match_with;

		return $init->merge($with);
	}

	public function isMatchedWith(User $user)
	{
		$userId = $user->user_id;
		$modelId = $this->user_id;

		return $this->matches()->contains(function(Match $match) use ($userId, $modelId) {
			return (
				($match->user_id1 === $userId || $match->user_id1 === $modelId)
				&& ($match->user_id2 === $userId || $match->user_id2 === $modelId)
			);
		});
	}

	/**
	 *
	 */
	public function notificationCount()
	{
		$matchCount = $this->pendingMatchCount();
		$messageCount = $this->unread_message_count();

		return ($matchCount + $messageCount);
	}

	/**
	 * Return a count of available matches the user has
	 *
	 * @return int
	 */
	public function availableMatchCount()
	{
		$user = $this;
		$purchasedMatches = MatchPurchase::totalForUser($this);
		$usedMatches = Match::findforUser($this, true)
			->filter(function(Match $match) use ($user) {
				return $match->isAcceptedBy($user);
			})->count();

		return ($purchasedMatches - $usedMatches);
	}

	/**
	 * Return the count of pending matches for the user
	 *
	 * @return int
	 */
	public function pendingMatchCount()
	{
		$matches = Match::pending($this)->count();
		$renewals = MatchRenewal::pending($this)->count();
		
		return ($matches + $renewals);
	}

	/**
	 * Fetches all Started Conversations
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function startedConversations()
	{
		return $this->hasMany(Conversation::class, $this->primaryKey);
	}

	/**
	 * Fetches all Subscribed Conversations
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function subscribedConversations()
	{
		return $this->belongsToMany(Conversation::class, 'conversation_user', $this->primaryKey, Conversation::PKEY)->withPivot('archived', 'last_read');
	}

	/**
	 * Get the reports filed against the user
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function violations()
	{
		return $this->hasMany(UserProfileViolation::class, 'subject_id', self::PKEY);
	}

	/**
	 * Get the reports filed by the user
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function filed_violations()
	{
		return $this->hasMany(UserProfileViolation::class, 'reported_by_id', self::PKEY);
	}

	/**
	 * Block a user
	 *
	 * @param User $user
	 * @param string $reason
	 * @return mixed
	 */
	public function block(User $user, $reason = null)
	{
		return $this->blocked()->save($user, ['reason' => $reason]);
	}

	/**
	 * Unblock a user
	 *
	 * @param User $user
	 * @return int
	 */
	public function unblock(User $user){
		return $this->blocked()->detach($user);
	}

	/**
	 * Get all blocked users for the given entity
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\Concerns\InteractsWithPivotTable
	 */
	public function blocked()
	{
		return $this->belongsToMany(User::class, 'user_blocks', 'user_id', 'blocked_user_id')
			->withPivot('reason', 'created_at', 'updated_at');
	}

	/**
	 * Get all users who block the given entity
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\Concerns\InteractsWithPivotTable
	 */
	public function blocked_by()
	{
		return $this->belongsToMany(User::class, 'user_blocks', 'blocked_user_id', 'user_id')
			->withPivot('reason', 'created_at', 'updated_at');
	}

	/**
	 * Sets Verified to true and deleted the token made in the register.
	 */
	public function verify_email()
	{
		$this->verified = true;
		$this->email_token = null;
		$this->save();
	}

	/*
	 * Get the reviews filed about the user
	 */
	public function reviews()
    {
        return $this->hasMany(Review::class, 'subject_user_id', self::PKEY)->orderBy('created_at');
    }

    /*
	 * Get the reviews filed by the user
	 */
    public function writtenReviews()
    {
        return $this->hasMany(Review::class, 'reviewer_user_id', self::PKEY)->orderBy('created_at');
    }

    /**
     * Returns their current Reviews Rating
     *
     * @return float|int
     */
    public function reviewRating()
    {
		$rating = $this->reviews->avg('rating');

		return (
			$rating !== null ? $rating : 5
		);
    }

	/**
	 * Check that the user can request a match with another user
	 *
	 * @return bool
	 */
    public function isAbleToRequestMatch()
	{
		if ($this->isIneligibleBroker()) {
			return false;
		}

		return true;
	}

	/**
	 * Check that the user can receive a match from another user
	 *
	 * @return bool
	 */
	public function isAbleToReceiveMatch()
	{
		if ($this->isIneligibleBroker()) {
			return false;
		}

		return true;
	}

	/**
	 * Is the broker ineligible for matching
	 *
	 * @return bool
	 */
	protected function isIneligibleBroker()
	{
		return (
			$this->user_type === UserAccountType::BROKER
				&& !$this->isPayingCustomer()
			//	&& !$this->subscribed('main')
		);
	}

	/**
	 * Get Match id
	 *
	 * @param User $user
	 * @throws \Exception
	 * @return mixed
	 */
	public function getMatchId(User $user)
	{
		$match = Match::findForUsers($this, $user, true);
		if (!$match) {
			throw new \Exception('No match found with the given user', 404);
		}

		return $match->match_id;
	}

	/**
	 * Get renewal ID
	 *
	 * @param User $user
	 * @throws \Exception
	 * @return mixed
	 */
	public function getMatchRenewalId(User $user)
	{
		$renewals = MatchRenewal::findForUsers($this, $user);

		if (!$renewals) {
			throw new \Exception('No match renewal found with the given user', 404);
		}

		return $renewals->match_id;
	}

	/**
	 * Apply user security the model
	 *
	 * @param Builder $query
	 * @param User $user
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function securityQuery(Builder $query, User $user) : Builder
	{
		return $query->where('users.user_id', $user->user_id);
	}

	/**
	 * Scope a query to only include realtors
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeRealtors($query)
	{
		return $query->where('user_type', UserAccountType::REALTOR);
	}

	/**
	 * Scope a query to only include brokers
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeBrokers($query)
	{
		return $query->where('user_type', UserAccountType::BROKER);
	}

	/**
	 * Scope a query to include users by state
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @param string $state
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeByState($query, string $state)
	{
		return $query->where('state', $state);
	}

	/**
	 * Scope a query to include users by miniumum experience
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @param int $exp
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeByExpMin($query, int $exp)
	{
		return $query->where('years_of_exp', '>=', $exp);
	}

	/**
	 * Scope a query to include users by maxiumum experience
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @param int $exp
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeByExpMax($query, int $exp)
	{
		return $query->where('years_of_exp', '<=', $exp);
	}

	/**
	 * Scope query to include the distance to the selected user. Use in
	 * conjunction with scopeDistance
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @param $lat
	 * @param $long
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeSelectDistance($query, $lat, $long)
	{
		$q = $this->distanceQuery;

		return $query->selectRaw("*, ${q} as distance", [$long, $lat]);
	}

	/**
	 * Scope query to limit selection to users within a specific distance
	 * of a lat/long
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @param $lat
	 * @param $long
	 * @param int $distance
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeDistance($query, $lat, $long, $distance)
	{
		$q = $this->distanceQuery;

		return $query->whereNotNull('latitude')
			->whereNotNull('longitude')
			->whereRaw("(${q}) < ?", [$long, $lat, $distance]);
	}


	public function isPrepaidCustomer()
	{
		if ($this->prepaid_period_ends_at !== null) {
			return (Carbon::today() <= $this->prepaid_period_ends_at);
		}

		return false;
	}

	/**
	 * Check if the user is a paying customer
	 * @return bool
	 */
	public function isPayingCustomer()
	{
		return ($this->isPrepaidCustomer()
			|| ($this->payment_status !== 0 
			
			//&& $this->subscribed('main')
			));
	}

	/**
	 * Get the users subscription plan
	 *
	 * @return \App\BraintreePlan
	 */
	public function subscriptionPlan()
	{
		$subscription = $this->subscription('main');

		return BraintreePlan::where('braintree_plan', $subscription->braintree_plan)->first();
	}

	/**
	 * Update the
	 */
	public function update_last_active()
	{
		$this->update([
			'last_activity' => Carbon::now(),
		]);
	}

	/**
	 * Check if the user has been active with the last n minutes
	 *
	 * @param int $threshold Time threshold to check the users last activity
	 *
	 * @return bool
	 */
	public function is_logged_in(int $threshold = 5)
	{
		/** @var Carbon $last_active */
		$last_active = $this->last_activity;

		return $last_active > Carbon::now()->subMinute($threshold);
	}

	/**
	 * Retrieve the users unread message count
	 *
	 * @return integer
	 */
	public function unread_message_count()
	{
		$user = $this;
		$conversations = $this->subscribedConversations;

		$unreadCount = $conversations->reduce(function ($count, Conversation $convo) use ($user) {
			$subscriber = $convo->subscribers->where('user_id', $user->user_id)->first();

			$messages = $convo->messages()->where('user_id', '!=', $user->user_id)
				->where('conversation_id', $convo->conversation_id)
				->where('updated_at', '>=', $subscriber->pivot->last_read)
				->get();
			return ($count + $messages->count());

		}, 0);

		return $unreadCount;
	}

	public function addPrepaidTime($duration = 1)
	{
		// is prepaid and prepaid has expired
		if ($this->prepaid_period_ends_at !== null && Carbon::now() > $this->prepaid_period_ends_at) {
			$endDate = Carbon::today()->addMonths($duration);
		} else if ($this->prepaid_period_ends_at !== null && Carbon::now() <= $this->prepaid_period_ends_at) {
			$endDate = $this->prepaid_period_ends_at->addMonths($duration);
		} else {
			$endDate = Carbon::today()->addMonths($duration);
			MatchPurchase::create([
				'user_id' => $this->user_id,
				'type' => MatchPurchaseType::COMPLIMENTARY,
				'quantity' => 2,
			]);
		}

		$this->prepaid_period_ends_at = $endDate;
		$this->save();
	}

	/*
	 ** Ago time
	 */
    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
    
    
    public function broker_match(){
         return $this->hasMany('App\Match');
    }
    
   
   public function unmatch_relator()
	{
		return $this->hasMany(Match::class, 'user_id2');
	}
   
   public function checkuser_with_unmatch()
   {
       return $this->belongsTo('App\MatchLog','user_id', 'user_with')->where('match_action', '=', 'accept');
       
   }


   /**
     * Get the subscription plan associated with the user.
     */
    public function userSubscription(){
        return $this->hasOne(UserSubscriptions::Class, UserSubscriptions::USER_ID, self::PKEY);
    }
   
	/**
     * Get the subscription plan associated with the user.
     */
    public function realtorDetail(){
        return $this->hasOne(RealtorDetail::Class, RealtorDetail::USER_ID, self::PKEY);
    }
	
	/**
     * Get the subscription plan associated with the user.
     */
    public function lenderDetail(){
        return $this->hasOne(LenderDetail::Class, LenderDetail::USER_ID, self::PKEY);
    }
	
	/**
     * Get the subscription plan associated with the user.
     */
    public function vendorMeta(){
        return $this->hasOne(VendorMeta::Class, VendorMeta::USER_ID, self::PKEY);
    }

	/**
     * Get the user leads.
     */
	public function userLeads() {
		return $this->hasMany(LeadNotificationRelationships::class, 'agent_id');
	}
}
