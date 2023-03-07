<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreateUserDetailsTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		DB::statement('
			CREATE TABLE "user_details" (
				"user_detail_id" BIGSERIAL NOT NULL PRIMARY KEY,
				"user_id" BIGINT NOT NULL REFERENCES "users" ("user_id") ON DELETE CASCADE ON UPDATE CASCADE,
				"register" TIMESTAMP WITH TIME ZONE NOT NULL,
				"verify" TIMESTAMP WITH TIME ZONE DEFAULT NULL,
				"lock" TIMESTAMP WITH TIME ZONE DEFAULT NULL,
				"dob" DATE NOT NULL,
				"created_at" TIMESTAMP(0) without TIME ZONE,
    			"updated_at" TIMESTAMP(0) without TIME ZONE
			)
		');

//		DB::statement('ALTER TABLE "user_details" OWNER TO "rtc_admin";');
//		DB::statement('GRANT SELECT ON "user_details" TO "rtc_user";');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		DB::statement('DROP TABLE IF EXISTS "user_details"');
    }
}
