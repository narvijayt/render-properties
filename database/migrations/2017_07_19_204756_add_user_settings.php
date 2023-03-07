<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserSettings extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('
			CREATE TABLE "user_settings" (
				"user_settings_id" BIGSERIAL NOT NULL PRIMARY KEY,
				"user_id" BIGINT UNIQUE NOT NULL REFERENCES "users" ("user_id") ON DELETE CASCADE ON UPDATE CASCADE,
				"created_at" TIMESTAMP(0) without TIME ZONE,
				"updated_at" TIMESTAMP(0) without TIME ZONE,
				"notify_email_messages" BOOLEAN NOT NULL DEFAULT TRUE
			)
		');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement('DROP TABLE IF EXISTS "user_settings"');
	}
}
