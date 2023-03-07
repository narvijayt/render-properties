<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVendorServiceToVendorDetailTable extends Migration
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
            ADD COLUMN "vendor_service" TEXT 
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
            DROP COLUMN IF EXISTS "vendor_service",
      ');
    }
}
