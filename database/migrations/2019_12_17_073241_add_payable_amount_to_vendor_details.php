<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPayableAmountToVendorDetails extends Migration
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
            ADD COLUMN "payable_amount" VARCHAR(255) DEFAULT NULL,
            ADD COLUMN "payment_status" VARCHAR(255) DEFAULT NULL
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
              DROP COLUMN IF EXISTS "payable_amount",
              DROP COLUMN IF EXISTS "payment_status"";
        ');
    }
}
