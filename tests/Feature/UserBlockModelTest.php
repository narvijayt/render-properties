<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\UserBlock;

class UserBlockModelTest extends TestCase
{
	use DatabaseMigrations;

	/**
	 * Test that a user block can be created
	 *
	 * @test
	 */
    public function a_user_block_can_be_created()
	{
		$block = factory(UserBlock::class)->states('with-users')->create();

		$this->assertNotNull($block);
	}

	/**
	 * @test
	 */
	public function a_user_block_can_fetch_its_owner()
	{
		/** @var User $user */
		$user = factory(User::class)->create();
		$blockedUser = factory(User::class)->create();

		$block = factory(UserBlock::class)->create([
			'user_id' => $user->user_id,
			'blocked_user_id' => $blockedUser->user_id,
		]);

		$this->assertEquals($user->user_id, $block->user->user_id);
	}

	/**
	 * @test
	 */
	public function a_user_block_can_fetch_its_blocked_user()
	{
		/** @var User $user */
		$user = factory(User::class)->create();
		$blockedUser = factory(User::class)->create();

		$block = factory(UserBlock::class)->create([
			'user_id' => $user->user_id,
			'blocked_user_id' => $blockedUser->user_id,
		]);

		$this->assertEquals($blockedUser->user_id, $block->blocked_user->user_id);
	}
}
