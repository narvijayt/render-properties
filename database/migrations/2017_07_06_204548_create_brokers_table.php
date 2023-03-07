<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrokersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		DB::statement('
			CREATE TABLE "brokers" (
				"broker_id" BIGSERIAL NOT NULL PRIMARY KEY,
				"user_id" BIGINT NOT NULL REFERENCES "users" ("user_id") ON DELETE CASCADE ON UPDATE CASCADE,
				"career_start" DATE NOT NULL,
				"years_exp" SMALLINT NOT NULL CHECK ("years_exp" IS NULL OR "years_exp" >= 0),
				"active" BOOLEAN NOT NULL DEFAULT TRUE,
				"created_at" TIMESTAMP(0) without TIME ZONE,
    			"updated_at" TIMESTAMP(0) without TIME ZONE
			)
		');

//		DB::self::statement('ALTER TABLE "brokers" OWNER TO "rtc_admin"');
//		DB::self::statement('GRANT SELECT ON "brokers" TO "rtc_user"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		DB::statement('DROP TABLE IF EXISTS "brokers"');
    }
}
