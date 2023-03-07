<?php

namespace Tests\Feature;

use App\UserProfileViolation;
use App\User;
use Symfony\Component\HttpKernel\Profiler\Profile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProfileViolationTest extends TestCase
{
	use DatabaseMigrations;

	/**
	 * Profile Violation Can be created
	 *
	 * @test
	 */
	public function a_profile_violation_model_can_be_created()
	{
		$violation = factory(UserProfileViolation::class)->states('with-users')->create();
		$this->assertNotNull($violation);
	}

	/**
	 * ProfileValidation Can fetch it's related reporting user
	 *
	 * @test
	 */
	public function a_profile_violation_model_can_fetch_its_reporter()
	{
		/**	@var UserProfileViolation $violation */
		$violation = factory(UserProfileViolation::class)->states('with-users')->create();

		$this->assertNotNull($violation->reporter->user_id);

	}

	/**
	 * ProfileValidation Can fetch it's related subject user
	 *
	 * @test
	 */
	public function a_profile_validation_model_can_fetch_its_subject()
	{
		/**	@var UserProfileViolation $violation */
		$violation = factory(UserProfileViolation::class)->states('with-users')->create();

		$this->assertNotNull($violation->subject->user_id);
	}

	/**
	 * ProfileValidation Can fetch it's related resolver user
	 *
	 * @test
	 */
	public function a_profile_validation_model_can_fetch_its_resolver()
	{
		/**	@var UserProfileViolation $violation */
		$violation = factory(UserProfileViolation::class)->states('with-users')->create();

		$this->assertNotNull($violation->resolver->user_id);
	}

	/**
	 * ProfileValidation can be attached to it's relations
	 *
	 * @test
	 */
	public function a_profile_validation_model_can_be_attached_to_its_relations()
	{
		/** @var User $reporter */
		$reporter = factory(User::class)->create();
		/** @var User $subject */
		$subject = factory(User::class)->create();

		/** @var UserProfileViolation $violation */
		$violation = factory(UserProfileViolation::class)->make();

		$violation->subject()->associate($subject);
		$violation->reporter()->associate($reporter);
		$violation->save();

		$violation = UserProfileViolation::find(1);

		$this->assertEquals($reporter->user_id, $violation->reporter->user_id);
		$this->assertEquals($subject->user_id, $violation->subject->user_id);
	}
}
