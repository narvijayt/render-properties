<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\UserDetail;

class UserDetailModelTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test that UserDetails can be created
     *
     * @test
     */
    public function a_user_detail_can_be_created()
    {
        $user = factory(User::class)->create();

        /** @var UserDetail $detail */
        $detail = factory(UserDetail::class)->make([
            'user_id' => $user->user_id
        ]);

        $this->assertTrue($detail->save());
    }

    /**
	 * Test that UserDetails can fetch it's related user
	 *
	 * @test
	 */
    public function a_user_detail_can_fetch_a_user_record()
	{
		$detail = factory(UserDetail::class)->states('with-user')->create();
		
		$this->assertNotNull($detail->user->user_id);
	}
}
