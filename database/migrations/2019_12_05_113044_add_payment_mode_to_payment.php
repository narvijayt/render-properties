<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentModeToPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         DB::statement('
         ALTER TABLE payment
          ADD COLUMN "payment_mode" VARCHAR(255) DEFAULT NULL,
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
            ALTER TABLE "payment"
              DROP COLUMN IF EXISTS "payment_mode";
        ');
    }
}
