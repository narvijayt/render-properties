<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
        	CREATE TABLE "user_blocks" (
        		"user_block_id" BIGSERIAL NOT NULL PRIMARY KEY,
        		"user_id" BIGINT NOT NULL REFERENCES "users" ("user_id") ON DELETE CASCADE ON UPDATE CASCADE,
        		"blocked_user_id" BIGINT REFERENCES "users" ("user_id") ON DELETE CASCADE ON UPDATE CASCADE,
        		"reason" TEXT DEFAULT NULL,
        		"created_at" TIMESTAMP(0) without TIME ZONE,
    			"updated_at" TIMESTAMP(0) without TIME ZONE,
    			UNIQUE("user_id", "blocked_user_id")
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
        DB::statement('DROP TABLE IF EXISTS "user_blocks"');
    }
}
