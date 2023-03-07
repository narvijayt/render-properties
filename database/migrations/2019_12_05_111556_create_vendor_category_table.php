<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
        CREATE TABLE "vendor_category" (
				"id"  BIGSERIAL PRIMARY KEY,
				"user_id" BIGINT NOT NULL REFERENCES "users" ("user_id") ON DELETE CASCADE ON UPDATE CASCADE,
				"category_id" VARCHAR(250) NOT NULL,
			    "vendor_contact" VARCHAR(255) DEFAULT NULL
			)
		');
		Schema::table('vendor_category', function (Blueprint $table) {
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists('vendor_category');
    }
}
