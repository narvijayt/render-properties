<?php

namespace Tests\Feature;

use App\Broker;
use App\BrokerSale;
use App\Permission;
use App\UserProfileViolation;
use App\Realtor;
use App\RealtorSale;
use App\Role;
use App\User;
use App\UserDetail;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Symfony\Component\HttpKernel\Profiler\Profile;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test that a user can save a user detail relation
     *
     * @@test
     */
    public function a_user_can_be_created()
    {
        /** @var User $user */
        $user = factory(User::class)->create();

        $this->assertTrue($user->save());

        $this->assertNotNull($user->user_id);
    }

    /**
     * Test that a user can save a user detail relation
     *
     * @@test
     */
    public function a_user_can_save_a_user_detail_relation()
    {
        $user = factory(User::class)->create();

        $detail = factory(UserDetail::class)->make();

        $user->detail()->save($detail);

        $this->assertEquals($user->user_id, $user->detail->user_id);
    }

	/**
	 * Test that a user can save a broker relation
	 *
	 * @@test
	 */
	public function a_user_can_save_a_broker_relation()
	{
		$user = factory(User::class)->create();

		$detail = factory(Broker::class)->make();

		$user->broker()->save($detail);

		$this->assertEquals($user->user_id, $user->broker->user_id);
	}

	/**
	 * Test that a user can save a realtor relation
	 *
	 * @@test
	 */
	public function a_user_can_save_a_realtor_relation()
	{
		$user = factory(User::class)->create();

		$detail = factory(Realtor::class)->make();

		$user->realtor()->save($detail);

		$this->assertEquals($user->user_id, $user->realtor->user_id);
	}

	/**
	 * Test that a user can save a realtor sales relation
	 *
	 * @@test
	 */
	public function a_user_can_save_a_realtor_sales_relation()
	{
		$user = factory(User::class)->create();

		$sales = [];

		$sales[] = factory(RealtorSale::class)->make([
			'sales_year' => 2017,
			'sales_month' => 1,
		]);

		$sales[] = factory(RealtorSale::class)->make([
			'sales_year' => 2017,
			'sales_month' => 2,
		]);

		$sales[] = factory(RealtorSale::class)->make([
			'sales_year' => 2017,
			'sales_month' => 3,
		]);

		$user->realtor_sales()->saveMany($sales);

		$this->assertEquals(3, $user->realtor_sales->count());

		foreach($user->realtor_sales as $sale) {
			$this->assertEquals($user->user_id, $sale->user_id);
		}
	}

	/**
	 * Test that a user can save a broker sales relation
	 *
	 * @@test
	 */
	public function a_user_can_save_a_broker_sales_relation()
	{
		$user = factory(User::class)->create();

		$sales = [];

		$sales[] = factory(BrokerSale::class)->make([
			'sales_year' => 2017,
			'sales_month' => 1,
		]);

		$sales[] = factory(BrokerSale::class)->make([
			'sales_year' => 2017,
			'sales_month' => 2,
		]);

		$sales[] = factory(BrokerSale::class)->make([
			'sales_year' => 2017,
			'sales_month' => 3,
		]);

		$user->broker_sales()->saveMany($sales);

		$this->assertEquals(3, $user->broker_sales->count());

		foreach($user->broker_sales as $sale) {

			$this->assertEquals($user->user_id, $sale->user_id);
		}
	}

    /**
     * Test that a role can be attached to a user using entrust
     *
     * @test
     */
	public function a_user_can_have_a_role()
    {
    	$admin = Role::where('name', 'admin')->first();
        /** @var User $user */
        $user = factory(User::class)->create();

        $user->attachRole($admin);

        $this->assertTrue($user->hasRole('admin'));
    }

    /**
     * Test that a role can be attached to a user using entrust
     *
     * @test
     */
    public function a_user_can_have_a_permission()
    {
        /** @var Role $admin */
        $admin = Role::where('name', 'admin')->first();
        /** @var Permission $editUser */
        $editUser = factory(Permission::class)->states('edit-users')->create();

        $admin->attachPermission($editUser);

        /** @var User $user */
        $user = factory(User::class)->create();

        $user->attachRole($admin);

        $this->assertTrue($user->hasRole('admin'));

        $this->assertTrue($user->can('edit-users'));
    }

	/**
	 * Test that a user can fetch their violations
	 *
	 * @test
	 */
    public function a_user_can_have_multiple_violations()
	{
		/** @var User $reporter */
		$reporter = factory(User::class)->create(['first_name' => 'Dick']);
		/** @var User $subject */
		$subject = factory(User::class)->create();

		factory(UserProfileViolation::class, 5)->create([
			'reported_by_id' => $reporter->user_id,
			'subject_id' => $subject->user_id,
		]);

		$this->assertEquals(5, $subject->violations->count());
		$this->assertEquals(5, $reporter->filed_violations->count());
	}

	/**
	 * Test that a user can save a violation
	 *
	 * @test
	 */
	public function a_user_can_save_multiple_violations()
	{
		/** @var User $reporter */
		$reporter = factory(User::class)->create(['first_name' => 'Dick']);
		/** @var User $subject */
		$subject = factory(User::class)->create();

		$violations = factory(UserProfileViolation::class, 5)->make([
			'reported_by_id' => $reporter->user_id
		]);

		$subject->violations()->saveMany($violations);

		$this->assertEquals(5, $subject->violations->count());
	}

	/**
	 * Test that a user can save multiple filed violations
	 *
	 * @test
	 */
	public function a_user_can_save_multiple_filed_violations()
	{
		/** @var User $reporter */
		$reporter = factory(User::class)->create(['first_name' => 'Dick']);
		/** @var User $subject */
		$subject = factory(User::class)->create();

		$violations = factory(UserProfileViolation::class, 5)->make([
			'subject_id' => $subject->user_id
		]);

		$reporter->filed_violations()->saveMany($violations);

		$this->assertEquals(5, $reporter->filed_violations->count());
	}

	/**
	 * @test
	 */
	public function a_user_can_block_another_user()
	{
		/** @var User $user */
		$user = factory(User::class)->create();
		$blockedUser = factory(User::class)->create();

		$reason = 'foo';

		$user->blocked()->save($blockedUser, ['reason' => $reason]);

		$blocked = $user->blocked()->find($blockedUser->user_id);
		$this->assertNotNull($blocked);

		$this->assertEquals($reason, $blocked->pivot->reason);
		$this->assertEquals($user->user_id, $blocked->pivot->user_id);
		$this->assertEquals($blockedUser->user_id, $blocked->pivot->blocked_user_id);

	}

	/**
	 * @test
	 */
	public function a_user_can_block_another_user_with_the_block_helper()
	{
		/** @var User $user */
		$user = factory(User::class)->create();
		$blockedUser = factory(User::class)->create();

		$reason = 'foo';
		$user->block($blockedUser, $reason);

		$blocked = $user->blocked()->find($blockedUser->user_id);
		$this->assertNotNull($blocked);

		$this->assertEquals($reason, $blocked->pivot->reason);
		$this->assertEquals($user->user_id, $blocked->pivot->user_id);
		$this->assertEquals($blockedUser->user_id, $blocked->pivot->blocked_user_id);
	}

	/**
	 * @test
	 */
	public function a_user_can_unblock_another_user_with_the_unblock_helper()
	{
		/** @var User $user */
		$user = factory(User::class)->create();
		$blockedUser = factory(User::class)->create();

		$reason = 'foo';
		$user->block($blockedUser, $reason);

		// verify block
		$blocked = $user->blocked()->find($blockedUser->user_id);
		$this->assertNotNull($blocked);

		// unblock
		$user->unblock($blockedUser);

		$blocked = $user->blocked()->find($blockedUser->user_id);
		$this->assertNull($blocked);
	}

	/**
	 * @test
	 */
	public function a_user_can_retrieve_all_user_who_block_it()
	{
		/** @var User $user */
		$user1 = factory(User::class)->create();
		$user2 = factory(User::class)->create();

		/** @var User $blockedUser */
		$blockedUser = factory(User::class)->create();

		$user1->block($blockedUser);
		$user2->block($blockedUser);

		// check block count
		$this->assertEquals(2, $blockedUser->blocked_by->count());
	}
}
