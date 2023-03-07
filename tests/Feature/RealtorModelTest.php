<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Realtor;

class RealtorModelTest extends TestCase
{
	use DatabaseMigrations;

	/**
	 * Broker Can be created
	 *
	 * @test
	 */
	public function a_broker_model_can_be_created()
	{
		$broker = factory(Realtor::class)->states('with-user')->create();
		$this->assertNotNull($broker);
	}

	/**
	 * Realtor Can fetch it's related user
	 *
	 * @test
	 */
	public function a_broker_model_can_fetch_its_user()
	{
		/**	@var Realtor $broker */
		$broker = factory(Realtor::class)->states('with-user')->create();

		$this->assertNotNull($broker->user->user_id);
	}
}
