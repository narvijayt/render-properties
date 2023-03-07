<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileViolationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
        	CREATE TABLE "user_profile_violations" (
        		"user_profile_violation_id" BIGSERIAL NOT NULL PRIMARY KEY,
        		"reported_by_id" BIGINT NOT NULL REFERENCES "users" ("user_id") ON DELETE CASCADE ON UPDATE CASCADE,
        		"subject_id" BIGINT NOT NULL REFERENCES "users" ("user_id") ON DELETE CASCADE ON UPDATE CASCADE,
        		"report" TEXT NOT NULL,
        		"resolved" BOOLEAN NOT NULL DEFAULT FALSE,
        		"resolved_by_id" BIGINT DEFAULT NULL REFERENCES "users" ("user_id") ON DELETE CASCADE ON UPDATE CASCADE,
        		"created_at" TIMESTAMP(0) without TIME ZONE,
    			"updated_at" TIMESTAMP(0) without TIME ZONE
        	);
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
        	DROP TABLE IF EXISTS "user_profile_violations";
        ');
    }
}
