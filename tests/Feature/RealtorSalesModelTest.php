<?php

namespace Tests\Feature;

use App\RealtorSale;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RealtorSalesModelTest extends TestCase
{
	use DatabaseMigrations;

	/**
	 * Broker Can be created
	 *
	 * @test
	 */
	public function a_realtor_sales_model_can_be_created()
	{
		$broker = factory(RealtorSale::class)->states('with-user')->create();
		$this->assertNotNull($broker);
	}

	/**
	 * RealtorSale Can fetch it's related user
	 *
	 * @test
	 */
	public function a_realtor_sales_model_can_fetch_its_user()
	{
		/**	@var RealtorSale $broker */
		$broker = factory(RealtorSale::class)->states('with-user')->create();

		$this->assertNotNull($broker->user->user_id);
	}
}
