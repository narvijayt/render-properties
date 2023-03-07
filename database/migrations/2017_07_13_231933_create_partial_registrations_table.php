<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartialRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            CREATE TYPE "social_provider_type" AS ENUM (
                \'facebook\'
	        )
        ');
        DB::statement('
          CREATE TABLE "partial_registrations" (
            "partial_registration_id" BIGSERIAL PRIMARY KEY,
            "first_name" VARCHAR(250),
			"last_name" VARCHAR(250),
			"email" VARCHAR(250) NOT NULL,
			"remember_token" UUID DEFAULT gen_random_uuid(),
			"provider" "social_provider_type",
			"provider_id" VARCHAR(64),
			"created_at" TIMESTAMP(0) without TIME ZONE,
    		"updated_at" TIMESTAMP(0) without TIME ZONE,
    		"deleted_at" TIMESTAMP(0) without TIME ZONE,
    		UNIQUE ("email", "provider")
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
        DB::statement('DROP TABLE IF EXISTS "partial_registrations"');
        DB::statement('DROP TYPE IF EXISTS "social_provider_type"');

    }
}
