<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Bouncer::seed();
      $this->call(AdminSeeder::class);
      $this->call(UserSeeder::class);
      $this->call(MatchSeeder::class);
      $this->call(ConversationSeeder::class);
      $this->call(ReviewsSeeder::class);
      $this->call(HomePageSeeder::class);
      $this->call(RealtorRegisterPageSeeder::class);
    }
}
