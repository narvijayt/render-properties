<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdditionalFieldsToVendorDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       DB::statement('
            ALTER TABLE "vendor_detail"
            ADD COLUMN "package_selected_state" VARCHAR(255) DEFAULT NULL,
            ADD COLUMN "package_selected_city" VARCHAR(255) DEFAULT NULL,
            ADD COLUMN "additional_city" VARCHAR(255) DEFAULT NULL,
            ADD COLUMN "additional_state" VARCHAR(255) DEFAULT NULL
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
            ALTER TABLE "vendor_detail"
              DROP COLUMN IF EXISTS "package_selected_state",
              DROP COLUMN IF EXISTS "package_selected_city",
              DROP COLUMN IF EXISTS "additional_city_and_states";
        ');
    }
}
