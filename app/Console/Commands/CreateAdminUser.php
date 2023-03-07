<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\User;
use App\Role;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Admin User.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
	{
//		DB::table('users')
//			->insert([
//				'username' => 'admin',
//				'email' => 'admin@realbrokerconnection.com',
//				'password' => bcrypt('R@d1xB@y'),
//				'title' => 'Dr',
//				'active' => true,
//				'first_name' => 'Real Broker',
//				'last_name' => 'Admin',
//				'created_at' => \Carbon\Carbon::now(),
//				'updated_at' => \Carbon\Carbon::now(),
//			]);

        $username = $this->ask('Username');
        $firstName = $this->ask('First Name');
        $lastName = $this->ask('Last Name');
        $password = $this->secret('Password');
        $email = $this->ask('Email');

        $user = new User;
        $user->fill([
        	'username' => $username,
			'first_name' => $firstName,
			'last_name' => $lastName,
			'active' => true,
			'password' => bcrypt($password),
			'email' => $email,
			'city' => 'Charlotte',
			'state' => 'NC',
			'zip' => '28226',
			'years_of_exp' => 100,
		]);
        $user->save();

		$user->assign('admin');

		$this->info('User created with admin role');
	}
}
