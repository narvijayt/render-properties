<?php

namespace Tests\Feature;

use App\BrokerSale;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BrokerSalesModelTest extends TestCase
{
	use DatabaseMigrations;

	/**
	 * Broker Can be created
	 *
	 * @test
	 */
	public function a_broker_sales_model_can_be_created()
	{
		$broker = factory(BrokerSale::class)->states('with-user')->create();
		$this->assertNotNull($broker);
	}

	/**
	 * BrokerSale Can fetch it's related user
	 *
	 * @test
	 */
	public function a_broker_sales_model_can_fetch_its_user()
	{
		/**	@var BrokerSale $broker */
		$broker = factory(BrokerSale::class)->states('with-user')->create();

		$this->assertNotNull($broker->user->user_id);
	}
}
