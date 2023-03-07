<?php

namespace Tests\Feature;

use App\Enums\MatchPurchaseType;
use App\Match;
use App\MatchPurchase;
use App\MatchRenewal;
use App\Policies\UserPolicy;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserPolicyTest extends TestCase
{
	use DatabaseMigrations, DatabaseTransactions;

	/**
	 * Create match purchase(s) for the given user
	 * @param User $user
	 * @param $quantity
	 */
	protected function createMatchPurchase(User $user, $quantity)
	{
		MatchPurchase::create([
			'user_id' => $user->user_id,
			'type' => MatchPurchaseType::COMPLIMENTARY,
			'quantity' => $quantity,
		]);
	}

	/**
	 * Create a valid subscription entry for the given user
	 *
	 * @param User $user
	 * @param null $endsAt
	 */
	protected function createSubscriptionForUser(User $user, $endsAt = null)
	{
		\DB::table('subscriptions')->insert([
			'user_id' => $user->user_id,
			'name' => 'main',
			'braintree_id' => '7df72f',
			'braintree_plan' => 'df8sf3',
			'quantity' => 1,
			'ends_at' => $endsAt,
			'created_at' => Carbon::now()->subDay(1),
			'updated_at' => Carbon::now()->subDay(1),
		]);

		$user->braintree_id = '123';
		$user->save();
	}

	/**
	 * Create a match for the given users
	 *
	 * @param User $user1
	 * @param User $user2
	 * @param \DateTime|null $acceptedAt1
	 * @param \DateTime|null $acceptedAt2
	 * @param \DateTime|null $deletedAt
	 * @return \App\Match
	 */
	protected function createMatchForUsers(
		User $user1,
		User $user2,
		\DateTime $acceptedAt1 = null,
		\DateTime $acceptedAt2 = null,
		\DateTime $deletedAt = null
	) {
		$matchId = \DB::table('matches')->insertGetId([
			'user_id1' => $user1->user_id,
			'user_type1' => $user1->user_type,
			'user_id2' => $user2->user_id,
			'user_type2' => $user2->user_type,
			'accepted_at1' => $acceptedAt1,
			'accepted_at2' => $acceptedAt2,
			'deleted_at' => $deletedAt,
		], 'match_id');

		return Match::withTrashed()->where('match_id', $matchId)->first();
	}

	/**
	 * Create a match renewal for the given match
	 *
	 * @param Match $match
	 * @param \DateTime|null $acceptedAt1
	 * @param \DateTime|null $acceptedAt2
	 * @param \DateTime|null $deletedAt
	 * @return \App\MatchRenewal
	 */
	protected function createMatchRenewalForUsers(
		Match $match,
		\DateTime $acceptedAt1 = null,
		\DateTime $acceptedAt2 = null,
		\DateTime $deletedAt = null
	) {
		$renewalId = \DB::table('match_renewal')->insertGetId([
			'match_id' => $match->match_id,
			'user_id1' => $match->user_id1,
			'user_id2' => $match->user_id2,
			'accepted_at1' => $acceptedAt1,
			'accepted_at2' => $acceptedAt2,
			'deleted_at' => $deletedAt,
		], 'match_id');

		return MatchRenewal::withTrashed()->where('match_id', $renewalId)->first();
	}

	/**
	 * @test
	 */
	public function request_match_a_user_cannot_match_with_a_user_of_the_same_type()
	{
		/** @var User $realtor */
		$realtor = factory(User::class)->states('type-realtor')->create();
		/** @var User $realtor2 */
		$realtor2 = factory(User::class)->states('type-realtor')->create();

		$this->createMatchPurchase($realtor, 1);
		$this->createMatchPurchase($realtor2, 1);

		$userPolicy = app()->make(UserPolicy::class);

		$this->assertFalse($userPolicy->requestMatch($realtor2, $realtor));
	}

	/**
	 * @test
	 */
	public function request_match_a_broker_without_a_subscription_cannot_request_a_match()
	{
		/** @var User $realtor */
		$realtor = factory(User::class)->states('type-realtor')->create();
		/** @var User $broker */
		$broker = factory(User::class)->states('type-broker')->create();

		$this->createMatchPurchase($realtor, 1);
		$this->createMatchPurchase($broker, 2);

		$userPolicy = app()->make(UserPolicy::class);

		$this->assertFalse($userPolicy->requestMatch($broker, $realtor));
	}

	/**
	 * @test
	 */
	public function request_match_a_user_with_a_sub_should_be_able_to_request_a_match()
	{
		/** @var User $realtor */
		$realtor = factory(User::class)->states('type-realtor')->create();
		/** @var User $broker */
		$broker = factory(User::class)->states('type-broker')->create();

		$this->createMatchPurchase($realtor, 1);
		$this->createMatchPurchase($broker, 2);

		$this->createSubscriptionForUser($broker);

		$userPolicy = app()->make(UserPolicy::class);

		$this->assertTrue($realtor->isAbleToReceiveMatch(), 'A realtor should be able to receive a match request');
		$this->assertTrue($broker->isAbleToRequestMatch(), 'A broker should be able to request a match');
		$this->assertTrue($userPolicy->requestMatch($broker, $realtor), 'A user with a valid subscription should be able to request a match');
	}

	/**
	 * @test
	 */
	public function request_match_both_users_must_have_available_matches_for_lender_to_request()
	{
		/** @var User $realtor */
		$realtor = factory(User::class)->states('type-realtor')->create();
		/** @var User $broker */
		$broker = factory(User::class)->states('type-broker')->create();

		$this->createMatchPurchase($broker, 2);
		$this->createSubscriptionForUser($broker);

		$userPolicy = app()->make(UserPolicy::class);

		$this->assertFalse($userPolicy->requestMatch($broker, $realtor));
	}

	/**
	 * @test
	 */
	public function request_match_only_realtor_must_have_available_matches_for_realtor_to_request()
	{
		/** @var User $realtor */
		$realtor = factory(User::class)->states('type-realtor')->create();
		/** @var User $broker */
		$broker = factory(User::class)->states('type-broker')->create();

		$this->createMatchPurchase($realtor, 2);
		$this->createSubscriptionForUser($broker);

		$userPolicy = app()->make(UserPolicy::class);

		$this->assertTrue($userPolicy->requestMatch($realtor, $broker));
	}

	/**
	 * @test
	 */
	public function request_match_users_with_existing_match_cannot_match_again()
	{
		/** @var User $realtor */
		$realtor = factory(User::class)->states('type-realtor')->create();
		/** @var User $broker */
		$broker = factory(User::class)->states('type-broker')->create();



		$this->createMatchPurchase($realtor, 1);
		$this->createMatchPurchase($broker, 2);

		$this->createSubscriptionForUser($broker);

		$userPolicy = app()->make(UserPolicy::class);

		$this->assertTrue($realtor->isAbleToReceiveMatch(), 'A realtor should be able to receive a match request');
		$this->assertTrue($broker->isAbleToRequestMatch(), 'A broker should be able to request a match');

		$this->createMatchForUsers($broker, $realtor, Carbon::now()->subDay(1));

		$this->assertFalse($userPolicy->requestMatch($broker, $realtor));
	}

	/**
	 * @test
	 */
	public function request_match_user_can_receive_match_if_they_have_unconfirmed_beyond_available_purchases()
	{
		/** @var User $realtor */
		$realtor = factory(User::class)->states('type-realtor')->create();
		/** @var User $broker */
		$broker = factory(User::class)->states('type-broker')->create();
		/** @var User $broker2 */
		$broker2 = factory(User::class)->states('type-broker')->create();


		$this->createMatchPurchase($realtor, 1);
//		$this->createMatchPurchase($broker, 1);
		$this->createMatchPurchase($broker2, 1);

		$this->createSubscriptionForUser($broker);
		$this->createSubscriptionForUser($broker2);

		$userPolicy = app()->make(UserPolicy::class);

		$this->assertTrue($realtor->isAbleToReceiveMatch(), 'A realtor should be able to receive a match request');
		$this->assertTrue($broker->isAbleToReceiveMatch(), 'A broker without available purchases should be able to receive a match');
		$this->assertFalse($broker->isAbleToRequestMatch(), 'A broker should not be able to request a match with outstanding matches equal to purchases');
		$this->assertTrue($broker2->isAbleToRequestMatch(), 'A broker should be able to request a match with no existing matches');
		$this->assertTrue($userPolicy->requestMatch($broker2, $realtor));
	}

	/**
	 * @test
	 */
	public function confirm_match_users_cannot_confirm_a_match_where_none_exists()
	{
		/** @var User $realtor */
		$realtor = factory(User::class)->states('type-realtor')->create();
		/** @var User $broker */
		$broker = factory(User::class)->states('type-broker')->create();

		$userPolicy = app()->make(UserPolicy::class);

		$this->assertFalse($userPolicy->confirmMatch($broker, $realtor));
	}

	/**
	 * @test
	 */
	public function confirm_match_cannot_confirm_match_if_it_has_already_been_confirmed_by_them()
	{
		/** @var User $realtor */
		$realtor = factory(User::class)->states('type-realtor')->create();
		/** @var User $broker */
		$broker = factory(User::class)->states('type-broker')->create();

		$this->createMatchForUsers($broker, $realtor, Carbon::now()->subDay(1));

		$userPolicy = app()->make(UserPolicy::class);

		$this->assertFalse($userPolicy->confirmMatch($broker, $realtor));
	}

	/**
	 * @test
	 */
	public function confirm_match_can_confirm_match_if_it_has_not_been_confirmed_by_them()
	{
		/** @var User $realtor */
		$realtor = factory(User::class)->states('type-realtor')->create();
		/** @var User $broker */
		$broker = factory(User::class)->states('type-broker')->create();

		$this->createSubscriptionForUser($broker);
		$this->createMatchPurchase($realtor, 1);
		$this->createMatchPurchase($broker, 1);

		$this->createMatchForUsers($broker, $realtor, null, Carbon::now()->subDay(1));

		$userPolicy = app()->make(UserPolicy::class);

		$this->assertFalse($realtor->isAbleToReceiveMatch(), 'The realtor should not be able to receive another match');
		$this->assertTrue($broker->isAbleToReceiveMatch(), 'The lender should be able to receive any number of matches');
		$this->assertTrue($broker->isAbleToRequestMatch(), 'The lender should be able to request a match');
		$this->assertTrue($userPolicy->confirmMatch($broker, $realtor));
	}

	/**
	 * @test
	 */
	public function confirm_match_can_confirm_match_if_it_has_not_been_confirmed_by_them_as_user2()
	{
		/** @var User $realtor */
		$realtor = factory(User::class)->states('type-realtor')->create();
		/** @var User $broker */
		$broker = factory(User::class)->states('type-broker')->create();

		$this->createSubscriptionForUser($broker);
		$this->createMatchPurchase($realtor, 1);
		$this->createMatchPurchase($broker, 1);

		$this->createMatchForUsers($realtor, $broker, Carbon::now()->subDay(1));

		$userPolicy = app()->make(UserPolicy::class);

		$this->assertFalse($realtor->isAbleToRequestMatch());
		$this->assertTrue($broker->isAbleToReceiveMatch());
		$this->assertTrue($broker->isAbleToRequestMatch());

		$this->assertTrue($userPolicy->confirmMatch($broker, $realtor));
	}

	/**
	 * @test
	 */
	public function confirm_match_cannot_confirm_match_if_it_has_not_been_confirmed_by_them_as_user2_without_purchased_matches()
	{
		/** @var User $realtor */
		$realtor = factory(User::class)->states('type-realtor')->create();
		/** @var User $realtor2 */
		$realtor2 = factory(User::class)->states('type-realtor')->create();
		/** @var User $broker */
		$broker = factory(User::class)->states('type-broker')->create();

		$this->createSubscriptionForUser($broker);
		$this->createMatchPurchase($realtor, 1);
		$this->createMatchPurchase($realtor2, 1);
		$this->createMatchPurchase($broker, 1);

		$this->createMatchForUsers($broker, $realtor, Carbon::now()->subDay(1), Carbon::now()->subMinute(10));
		$this->createMatchForUsers($realtor2, $broker, Carbon::now()->subDay(1));

		$userPolicy = app()->make(UserPolicy::class);

		$this->assertFalse($realtor->isAbleToRequestMatch());
		$this->assertFalse($realtor2->isAbleToRequestMatch());

		$this->assertTrue($broker->isAbleToReceiveMatch());
		$this->assertFalse($broker->isAbleToRequestMatch());

		$this->assertFalse($userPolicy->confirmMatch($broker, $realtor2));
	}

	/**
	 * @test
	 */
	public function remove_match_a_user_cannot_remove_match_which_doesnt_exist()
	{
		/** @var User $realtor */
		$realtor = factory(User::class)->states('type-realtor')->create();
		/** @var User $broker */
		$broker = factory(User::class)->states('type-broker')->create();

		$userPolicy = app()->make(UserPolicy::class);

		$this->assertFalse($userPolicy->removeMatch($broker, $realtor));
	}

	/**
	 * @test
	 */
	public function remove_match_a_user_can_remove_match_if_they_are_a_member_of_it()
	{
		/** @var User $realtor */
		$realtor = factory(User::class)->states('type-realtor')->create();
		/** @var User $broker */
		$broker = factory(User::class)->states('type-broker')->create();

		$this->createMatchForUsers($broker, $realtor, Carbon::now()->subHour(1));

		$userPolicy = app()->make(UserPolicy::class);

		$this->assertTrue($userPolicy->removeMatch($broker, $realtor));
	}

	/**
	 * @test
	 */
	public function remove_match_a_user_cannot_remove_match_if_they_are_not_a_member()
	{
		/** @var User $realtor */
		$realtor = factory(User::class)->states('type-realtor')->create();
		/** @var User $realtor2 */
		$realtor2 = factory(User::class)->states('type-realtor')->create();
		/** @var User $broker */
		$broker = factory(User::class)->states('type-broker')->create();

		$this->createMatchForUsers($broker, $realtor, Carbon::now()->subHour(1));

		$userPolicy = app()->make(UserPolicy::class);

		$this->assertFalse($userPolicy->removeMatch($broker, $realtor2));
	}

	/**
	 * @test
	 */
	public function renew_match_a_user_cannot_renew_match_with_themselves()
	{
		/** @var User $realtor */
		$realtor = factory(User::class)->states('type-realtor')->create();

		$userPolicy = app()->make(UserPolicy::class);

		$this->assertFalse($userPolicy->renewMatch($realtor, $realtor));
	}

	/**
	 * @test
	 */
	public function renew_match_a_user_cannot_renew_a_match_which_does_not_exist()
	{
		/** @var User $realtor */
		$realtor = factory(User::class)->states('type-realtor')->create();
		/** @var User $broker */
		$broker = factory(User::class)->states('type-broker')->create();

		$userPolicy = app()->make(UserPolicy::class);

		$this->assertFalse($userPolicy->renewMatch($broker, $realtor));
	}

	/**
	 * @test
	 */
	public function renew_match_a_user_cannot_renew_a_match_which_has_not_been_deleted()
	{
		/** @var User $realtor */
		$realtor = factory(User::class)->states('type-realtor')->create();
		/** @var User $broker */
		$broker = factory(User::class)->states('type-broker')->create();

		$this->createMatchForUsers(
			$broker,
			$realtor,
			Carbon::now()->subHour(1),
			Carbon::now()->subHour(1)
		);

		$userPolicy = app()->make(UserPolicy::class);

		$this->assertFalse($userPolicy->renewMatch($broker, $realtor));
	}

	/**
	 * @test
	 */
	public function renew_match_a_user_can_renew_a_deleted_match_when_a_renewal_does_not_exist()
	{
		/** @var User $realtor */
		$realtor = factory(User::class)->states('type-realtor')->create();
		/** @var User $broker */
		$broker = factory(User::class)->states('type-broker')->create();

		$this->createMatchForUsers(
			$broker,
			$realtor,
			Carbon::now()->subHour(1),
			Carbon::now()->subHour(1),
			Carbon::now()
		);

		$userPolicy = app()->make(UserPolicy::class);

		$this->assertTrue($userPolicy->renewMatch($broker, $realtor));
	}

	/**
	 * @test
	 */
	public function renew_match_a_user_can_not_accept_a_renewal_if_they_have_accepted_it_previously()
	{
		/** @var User $realtor */
		$realtor = factory(User::class)->states('type-realtor')->create();
		/** @var User $broker */
		$broker = factory(User::class)->states('type-broker')->create();

		$match = $this->createMatchForUsers(
			$broker,
			$realtor,
			Carbon::now()->subHour(1),
			Carbon::now()->subHour(1),
			Carbon::now()
		);

		$this->createMatchRenewalForUsers($match, Carbon::now()->subDay(1));

		$userPolicy = app()->make(UserPolicy::class);

		$this->assertFalse($userPolicy->renewMatch($broker, $realtor));
	}

	/**
	 * @test
	 */
	public function renew_match_a_user_can_not_renew_a_match_if_one_has_already_been_created()
	{
		/** @var User $realtor */
		$realtor = factory(User::class)->states('type-realtor')->create();
		/** @var User $broker */
		$broker = factory(User::class)->states('type-broker')->create();

		$match = $this->createMatchForUsers(
			$broker,
			$realtor,
			Carbon::now()->subHour(1),
			Carbon::now()->subHour(1),
			Carbon::now()
		);

		$this->createMatchRenewalForUsers($match, null, Carbon::now()->subDay(1));

		$userPolicy = app()->make(UserPolicy::class);

		$this->assertFalse($userPolicy->renewMatch($broker, $realtor), 'Match Renewal should not be created if one already exists');
	}

	/**
	 * @test
	 */
	public function accept_renew_match_a_user_should_not_be_able_to_accept_a_match_with_themselves()
	{
		/** @var User $realtor */
		$realtor = factory(User::class)->states('type-realtor')->create();

		$userPolicy = app()->make(UserPolicy::class);

		$this->assertFalse($userPolicy->acceptRenewMatch($realtor, $realtor));
	}

	/**
	 * @test
	 */
	public function accept_renew_match_a_user_cannot_renew_a_match_that_does_not_exist()
	{
		/** @var User $realtor */
		$realtor = factory(User::class)->states('type-realtor')->create();
		/** @var User $broker */
		$broker = factory(User::class)->states('type-broker')->create();

		$userPolicy = app()->make(UserPolicy::class);

		$this->assertFalse($userPolicy->acceptRenewMatch($broker, $realtor));
	}

	/**
	 * @test
	 */
	public function accept_renew_match_a_user_cannot_accept_a_match_renewal_for_a_match_that_has_not_been_deleted()
	{
		/** @var User $realtor */
		$realtor = factory(User::class)->states('type-realtor')->create();
		/** @var User $broker */
		$broker = factory(User::class)->states('type-broker')->create();

		$this->createMatchForUsers(
			$broker,
			$realtor,
			Carbon::now()->subHour(1),
			Carbon::now()->subHour(1)
		);

		$userPolicy = app()->make(UserPolicy::class);

		$this->assertFalse($userPolicy->acceptRenewMatch($broker, $realtor));
	}

	/**
	 * @test
	 */
	public function accept_renew_match_a_user_can_accept_a_match_renewal_which_they_have_not_already_accepted()
	{
		/** @var User $realtor */
		$realtor = factory(User::class)->states('type-realtor')->create();
		/** @var User $broker */
		$broker = factory(User::class)->states('type-broker')->create();

		$match = $this->createMatchForUsers(
			$broker,
			$realtor,
			Carbon::now()->subHour(1),
			Carbon::now()->subHour(1),
			Carbon::now()
		);

		$this->createMatchRenewalForUsers($match, null, Carbon::now()->subHour(2));

		$userPolicy = app()->make(UserPolicy::class);

		$this->assertTrue($userPolicy->acceptRenewMatch($broker, $realtor));
	}

	/**
	 * @test
	 */
	public function reject_renew_match_a_user_cannot_renew_a_match_when_the_renewal_has_been_deleted()
	{
		/** @var User $realtor */
		$realtor = factory(User::class)->states('type-realtor')->create();
		/** @var User $broker */
		$broker = factory(User::class)->states('type-broker')->create();

		$match = $this->createMatchForUsers(
			$broker,
			$realtor,
			Carbon::now()->subHour(1),
			Carbon::now()->subHour(1),
			Carbon::now()
		);

		$this->createMatchRenewalForUsers($match, null, Carbon::now()->subDay(1), Carbon::now()->subHour(2));

		$userPolicy = app()->make(UserPolicy::class);

		$this->assertFalse($userPolicy->rejectRenewMatch($broker, $realtor));
	}

	/**
	 * @test
	 */
	public function reject_renew_match_a_user_can_delete_a_renewal_request_when_it_has_not_been_deleted_yet()
	{
		/** @var User $realtor */
		$realtor = factory(User::class)->states('type-realtor')->create();
		/** @var User $broker */
		$broker = factory(User::class)->states('type-broker')->create();

		$match = $this->createMatchForUsers(
			$broker,
			$realtor,
			Carbon::now()->subHour(1),
			Carbon::now()->subHour(1),
			Carbon::now()
		);

		$this->createMatchRenewalForUsers(
			$match,
			null,
			Carbon::now()->subDay(1)
		);

		$userPolicy = app()->make(UserPolicy::class);

		$this->assertTrue($userPolicy->rejectRenewMatch($broker, $realtor));
	}
}
