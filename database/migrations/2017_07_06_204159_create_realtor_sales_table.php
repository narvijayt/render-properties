<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRealtorSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		DB::statement('
			CREATE TABLE "realtor_sales" (
				"realtor_sales_id" BIGSERIAL NOT NULL PRIMARY KEY,
				"realtor_id" BIGINT NOT NULL REFERENCES "realtors" ("realtor_id") ON DELETE CASCADE ON UPDATE CASCADE,
				"sales_year" SMALLINT NOT NULL CHECK ("sales_year" >= 1900 OR "sales_year" <= 9999),
				"sales_month" SMALLINT NOT NULL CHECK ("sales_month" >= 1 OR "sales_month" >= 12),
				"sales_total" SMALLINT NOT NULL CHECK ("sales_total" >= 0),
				"created_at" TIMESTAMP(0) without TIME ZONE,
    			"updated_at" TIMESTAMP(0) without TIME ZONE,
    			UNIQUE ("realtor_id", "sales_year", "sales_month")
			)
		');

//		DB::statement('ALTER TABLE "realtor_sales" OWNER TO "rtc_admin"');
//		DB::statement('GRANT SELECT ON "realtor_sales" TO "rtc_user"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		DB::statement('DROP TABLE IF EXISTS "realtor_sales"');
    }
}
