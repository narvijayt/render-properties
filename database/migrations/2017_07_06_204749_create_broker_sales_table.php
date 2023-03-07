<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrokerSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		DB::statement('
			CREATE TABLE "broker_sales" (
				"broker_sales_id" BIGSERIAL NOT NULL PRIMARY KEY,
				"broker_id" BIGINT NOT NULL REFERENCES "brokers" ("broker_id") ON DELETE CASCADE ON UPDATE CASCADE,
				"sales_year" SMALLINT NOT NULL CHECK ("sales_year" >= 1900 OR "sales_year" <= 9999),
				"sales_month" SMALLINT NOT NULL CHECK ("sales_month" >= 1 OR "sales_month" >= 12),
				"sales_total" SMALLINT NOT NULL CHECK ("sales_total" >= 0),
				"created_at" TIMESTAMP(0) without TIME ZONE,
				"updated_at" TIMESTAMP(0) without TIME ZONE,
				UNIQUE ("broker_id", "sales_year", "sales_month")
			)
		');

//		DB::statement('ALTER TABLE "broker_sales" OWNER TO "rtc_admin"');
//		DB::statement('GRANT SELECT ON "broker_sales" TO "rtc_user"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		DB::statement('DROP TABLE IF EXISTS "broker_sales"');
    }
}
