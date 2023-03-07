<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMembershipLevelsToUsers extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('
			ALTER TABLE "users" ADD COLUMN "user_type" "user_account_type" DEFAULT NULL
		');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement('
			ALTER TABLE "users" DROP COLUMN IF EXISTS "user_type"
		');
	}
}
