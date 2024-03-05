<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMatchingTables extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('
			CREATE TYPE "user_account_type" AS ENUM (
				\'realtor\',
				\'broker\',
				\'vendor\'
			)
		');
		DB::statement('
			CREATE TYPE "match_action_type" AS ENUM (
				\'initial\',
				\'accept\',
				\'reject\',
				\'remove\',
				\'renew\'
			)
		');
		DB::statement('
			CREATE TABLE "matches" (
				"match_id" UUID NOT NULL PRIMARY KEY DEFAULT gen_random_uuid(),
				"user_id1" BIGINT NOT NULL REFERENCES "users" ("user_id") ON DELETE CASCADE ON UPDATE CASCADE,
				"user_type1" "user_account_type" NOT NULL,
				"user_id2" BIGINT NOT NULL REFERENCES "users" ("user_id") ON DELETE CASCADE ON UPDATE CASCADE,
				"user_type2" "user_account_type" NOT NULL,
				"accepted_at1" TIMESTAMP(0) without TIME ZONE DEFAULT NULL,
				"accepted_at2" TIMESTAMP(0) without TIME ZONE DEFAULT NULL,
				"created_at" TIMESTAMP(0) without TIME ZONE NOT NULL DEFAULT \'now\',
				"updated_at" TIMESTAMP(0) without TIME ZONE NOT NULL DEFAULT \'now\',
				"deleted_at" TIMESTAMP(0) without TIME ZONE DEFAULT NULL,
				UNIQUE ("user_id1", "user_type1", "user_id2", "user_type2"),
				CHECK ("user_id1" <> "user_id2"),
				CHECK ("user_type1" <> "user_type2"),
				CHECK ("accepted_at1" IS NOT NULL OR "accepted_at2" IS NOT NULL)
			)
		');
		DB::statement('
			CREATE TABLE "match_renewal" (
				"match_id" UUID NOT NULL PRIMARY KEY REFERENCES "matches" ("match_id") ON DELETE CASCADE ON UPDATE CASCADE,
				"user_id1" BIGINT NOT NULL REFERENCES "users" ("user_id") ON DELETE CASCADE ON UPDATE CASCADE,
				"user_id2" BIGINT NOT NULL REFERENCES "users" ("user_id") ON DELETE CASCADE ON UPDATE CASCADE,
				"accepted_at1" TIMESTAMP(0) without TIME ZONE DEFAULT NULL,
				"accepted_at2" TIMESTAMP(0) without TIME ZONE DEFAULT NULL,
				"created_at" TIMESTAMP(0) without TIME ZONE NOT NULL DEFAULT \'now\',
				"updated_at" TIMESTAMP(0) without TIME ZONE NOT NULL DEFAULT \'now\',
				"deleted_at" TIMESTAMP(0) without TIME ZONE DEFAULT NULL,
				CHECK ("accepted_at1" IS NOT NULL OR "accepted_at2" IS NOT NULL)
			)
		');
		DB::statement('
			CREATE TABLE "match_logs" (
				"match_log_id" BIGSERIAL NOT NULL PRIMARY KEY,
				"match_id" UUID NOT NULL,
				"renew_id" UUID DEFAULT NULL,
				"user_init" BIGINT NOT NULL REFERENCES "users" ("user_id") ON DELETE CASCADE ON UPDATE CASCADE,
				"user_with" BIGINT NOT NULL REFERENCES "users" ("user_id") ON DELETE CASCADE ON UPDATE CASCADE,
				"match_action" "match_action_type" NOT NULL,
				"created_at" TIMESTAMP(0) without TIME ZONE NOT NULL DEFAULT \'now\',
				"updated_at" TIMESTAMP(0) without TIME ZONE NOT NULL DEFAULT \'now\',
				UNIQUE ("match_id", "user_init", "user_with", "created_at"),
				CHECK ("created_at" = "updated_at")
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
		DB::statement('DROP TABLE "match_logs"');
		DB::statement('DROP TABLE "match_renewal"');
		DB::statement('DROP TABLE "matches"');
		DB::statement('DROP TYPE "match_action_type"');
		DB::statement('DROP TYPE "user_account_type"');
	}
}
