<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBraintreeIdToVendorCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         DB::statement('
            ALTER TABLE "vendor_category"
            ADD COLUMN "braintree_id" bigint 
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
            ALTER TABLE "vendor_category"
            DROP COLUMN IF EXISTS "braintree_id",
      ');
    }
}
