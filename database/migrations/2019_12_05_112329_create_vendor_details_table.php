<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       DB::statement('
    		CREATE TABLE "vendor_detail" (
    			"id" BIGSERIAL NOT NULL PRIMARY KEY,
				"user_id" BIGINT NOT NULL REFERENCES "users" ("user_id") ON DELETE CASCADE ON UPDATE CASCADE,
			     "vendor_coverage_area" TEXT NOT NULL,
			    "created_at" TIMESTAMP(0) without TIME ZONE,
                "updated_at" TIMESTAMP(0) without TIME ZONE,
                "deleted_at" TIMESTAMP(0) without TIME ZONE,
                UNIQUE ("user_id")
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
        DB::statement('DROP TABLE IF EXISTS "vendor_detail"');
    }
}
