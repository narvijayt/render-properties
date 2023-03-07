<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaidByUserIdPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       DB::statement('
            ALTER TABLE "payment"
            ADD COLUMN "paid_by_user_id" bigint 
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
            DROP COLUMN IF EXISTS "paid_by_user_id", 
      ');
    }
}
