<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRealtorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		DB::statement('
			CREATE TABLE "realtors" (
				"realtor_id" BIGSERIAL NOT NULL PRIMARY KEY,
				"user_id" BIGINT NOT NULL REFERENCES "users" ("user_id") ON DELETE CASCADE ON UPDATE CASCADE,
				"career_start" DATE NOT NULL,
				"years_exp" SMALLINT NOT NULL CHECK ("years_exp" IS NULL OR "years_exp" >= 0),
				"active" BOOLEAN NOT NULL DEFAULT TRUE,
				"created_at" TIMESTAMP(0) without TIME ZONE,
    			"updated_at" TIMESTAMP(0) without TIME ZONE
			)
		');

//		DB::statement('ALTER TABLE "realtors" OWNER TO "rtc_admin"');
//		DB::statement('GRANT SELECT ON "realtors" TO "rtc_user"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		DB::statement('DROP TABLE IF EXISTS "realtors"');
    }
}
