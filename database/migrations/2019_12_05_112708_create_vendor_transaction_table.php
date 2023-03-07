<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
        CREATE TABLE "payment" (
				"id"  BIGSERIAL PRIMARY KEY,
				"user_id" BIGINT NOT NULL REFERENCES "users" ("user_id") ON DELETE CASCADE ON UPDATE CASCADE,
				"subscription_id" VARCHAR(250) NOT NULL,
				"braintree_id" VARCHAR(250) NOT NULL,
				"total_amount" VARCHAR(250) NOT NULL,
				"user_type" VARCHAR(250) NOT NULL
			)
		');
			Schema::table('payment', function (Blueprint $table) {
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
        Schema::dropIfExists('payment');
    }
}
