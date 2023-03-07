<?php

namespace App\Policies;

use App\Enums\UserAccountType;
use App\Enums\UserRolesEnum;
use App\Match;
use App\MatchRenewal;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Collection;

class UserPolicy
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
	 * Determine if the currently authed user can report the user model
	 *
	 * @param User $user
	 * @param User $model
	 * @return boolean
	 */
    public function report(User $user, User $model)
	{
		return (
			$this->isLoggedIn() === true
				&& $this->isSelf($model) === false
		);
	}

	/**
	 * Determine if the user can block another user
	 *
	 * @param User $user
	 * @param User $model
	 * @return bool
	 */
	public function block(User $user, User $model)
	{
		return (
			$this->isLoggedIn() === true
				&& $this->isSelf($model) === false
				&& $user->blocked()->find($model->user_id) === null
		);
	}

	/**
	 * Determine if the user can unblock another user
	 *
	 * @param User $user
	 * @param User $model
	 * @return bool
	 */
	public function unblock(User $user, User $model)
	{
		return (
			$this->isLoggedIn() === true
				&& $this->isSelf($model) === false
				&& $user->blocked()->find($model->user_id) !== null
		);
	}

	/**
	 * Check to see if a user can match with another user
	 * @param User $authUser
	 * @param User $model
	 * @return bool
	 */
	public function requestMatch(User $authUser, User $model)
	{
		if (
			$authUser->user_type !== $model->user_type
				&& $authUser->isAbleToRequestMatch()
				&& $model->isAbleToReceiveMatch()
				&& !Match::findForUsers($authUser, $model, true)
		) {
			return true;
		}

		return false;
	}

	/**
	 * Check that the authorized user can confirm a match with the given user.
	 *
	 * @param User $authUser
	 * @param User $model
	 * @return bool
	 */
	public function confirmMatch(User $authUser, User $model)
	{
		/** @var \App\Match $match */
		$match = Match::findForUsers($authUser, $model, true);

		if (!$match) {
			return false;
		}

		if ($authUser->availableMatchCount() <= 0) {
			return false;
		}

		if (
			($match->user_id1 === $authUser->user_id && $match->accepted_at1 === null)
			|| ($match->user_id2 === $authUser->user_id && $match->accepted_at2 === null)
		) {
			return true;
		}

		return false;
	}

	/**
	 * Check that the user can remove a match
	 * @param User $authUser
	 * @param User $model
	 * @return bool
	 */
	public function removeMatch(User $authUser, User $model)
	{
		/** @var Collection $matches */
		$matches = Match::findForUsers($authUser, $model, true);
		if ($matches === null) {
			return false;
		}

		return (
			$matches->count() === 0 ? false : true
		);
	}

	/**
	 * Check if a user can renew a match
	 *
	 * @param User $authUser
	 * @param User $model
	 * @return bool
	 */
	public function renewMatch(User $authUser, User $model)
	{
		if ($authUser->user_id === $model->user_id) {
			return false;
		}

		/** @var Match $match */
		$match = Match::findForUsers($authUser, $model, true);

		return (
			$match !== null
				&& $match->deleted_at !== null
				&& !$match->renewal
		);
	}

	/**
	 * Check if a user can renew a match
	 *
	 * @param User $authUser
	 * @param User $model
	 * @return bool
	 */
	public function acceptRenewMatch(User $authUser, User $model)
	{
		if ($authUser->user_id === $model->user_id) {
			return false;
		}

		/** @var Match $match */
		$match = Match::findForUsers($authUser, $model, true);

		return (
			$match !== null
				&& $match->deleted_at !== null
				&& $match->renewal
				&& !$match->renewal->isAcceptedBy($authUser)
		);
	}

	public function rejectRenewMatch(User $authUser, User $model)
	{
		$renewal = MatchRenewal::findForUsers($authUser, $model, true);

		return (
			$renewal !== null && $renewal->deleted_at === null
		);
	}

	/**
	 * Determine if the realtor has a match that has been accepted by both parties
	 *
	 * @param User $realtor
	 * @return bool
	 */
	protected function isRealtorAvailable(User $realtor)
	{
		$matches = $realtor->matches();

		if ($matches->count() === 0) {
			return true;
		}

		// will be true if the realtor has any matches that are confirmed
		$res = $matches->contains(function(Match $match) {
			return $match->isAccepted();
		});

		return !$res;
	}

	/**
	 * Determine if the user can manage payment as a broker
	 *
	 * @param User $user
	 * @return bool
	 */
	public function managePayment(User $user) {
		return ($user->user_type === UserAccountType::BROKER);
	}

	/**
	 * Determine if the user can create a subscription based on user type
	 * and current subscription status
	 *
	 * @param User $user
	 * @return bool
	 */
	public function createSubscription(User $user)
	{
		return ($user->user_type === UserAccountType::BROKER
			&& !$user->subscribed('main'));
	}

	/**
	 * Determine if the user can cancel their subscription
	 *
	 * @param User $user
	 * @return bool
	 */
	public function cancelSubscription(User $user)
	{
		return (
			$user->user_type === UserAccountType::BROKER
				&& !$user->subscription('main')->cancelled()
		);
	}

	/**
	 * Determine if the user can resume their subscription
	 *
	 * @param User $user
	 * @return bool
	 */
	public function resumeSubscription(User $user)
	{
		return (
			$user->user_type === UserAccountType::BROKER
				&& $user->subscription('main')->onGracePeriod()
		);
	}

	public function changeSubscription(User $user)
	{
		$sub = $user->subscription('main');
		return (
			$user->user_type === UserAccountType::BROKER
				&& $sub->active()
				&& !$sub->onGracePeriod()
		);
	}

	public function managePaymentMethods(User $user)
	{
		return (
			$user->user_type === UserAccountType::BROKER
				&& $user->braintree_id !== null
		);
	}

	public function purchaseAdditionalMatches(User $user)
	{
		return (
			$user->user_type === UserAccountType::BROKER
				&& $user->subscribed('main')
				&& $user->braintree_id !== null
		);
	}

	public function brokerViewProfiles(User $user) {
		return (
			!$this->auth->guest() &&
			$user->isNotA('broker') ||
				(
					$user->isA('broker') &&
					$user->braintree_id !== null 
				)
		);
	}

    /**
     * Determine if the user can manage page as a admin
     *
     * @param User $user
     * @return bool
     */
    public function managePage(User $user) {
        return ($user->username === UserRolesEnum::ADMIN);
    }
}
