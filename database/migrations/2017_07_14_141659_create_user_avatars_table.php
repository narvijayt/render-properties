<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAvatarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
        	CREATE TABLE "user_avatars" (
        		"user_avatar_id" BIGSERIAL PRIMARY KEY,
        		"user_id" BIGINT NOT NULL REFERENCES "users" ("user_id") ON DELETE CASCADE ON UPDATE CASCADE,
        		"name" VARCHAR(255) NOT NULL UNIQUE,
        		"original_name" VARCHAR(255) NOT NULL,
        		"created_at" TIMESTAMP(0) without TIME ZONE,
    			"updated_at" TIMESTAMP(0) without TIME ZONE,
    			"deleted_at" TIMESTAMP(0) without TIME ZONE,
    			UNIQUE("name")
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
    	DB::statement('DROP TABLE IF EXISTS "user_avatars"');
    }
}
