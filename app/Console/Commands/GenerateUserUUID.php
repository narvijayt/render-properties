<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Ramsey\Uuid\Uuid;

class GenerateUserUUID extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:generate-uuid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate UUIDs for all users';

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
        User::whereNull('uid')
			->get()
			->each(function(User $user) {
				$user->update([
					'uid' => Uuid::uuid4()->toString(),
				]);
			});
    }
}
