<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProviders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
    		CREATE TABLE "user_providers" (
				"user_provider_id"  BIGSERIAL PRIMARY KEY,
				"user_id" BIGINT NOT NULL REFERENCES "users" ("user_id") ON DELETE CASCADE ON UPDATE CASCADE,
			    "email" VARCHAR(250) NOT NULL,				
				"provider" "social_provider_type" NOT NULL,
			    "provider_id" VARCHAR(64) NOT NULL ,
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
        DB::statement('DROP TABLE IF EXISTS "user_providers"');
    }
}
