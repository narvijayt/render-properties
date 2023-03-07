<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$user = factory(App\User::class)->create([
			'username' => 'admin',
			'email' => 'admin@realbrokerconnection.com',
			'first_name' => 'Admin',
			'last_name' => 'Test',
            'user_type' => null,
		]);

		$user->assign('owner');
	}
}
