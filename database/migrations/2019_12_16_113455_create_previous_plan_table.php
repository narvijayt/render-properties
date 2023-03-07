<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreviousPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       DB::statement('
        CREATE TABLE "previous_plan" (
				"id"  BIGSERIAL PRIMARY KEY,
				"user_id" BIGINT NOT NULL REFERENCES "users" ("user_id") ON DELETE CASCADE ON UPDATE CASCADE,
				"subscription_id" VARCHAR(250) NOT NULL,
				"braintree_id" VARCHAR(250) NOT NULL,
				"total_amount" VARCHAR(250) NOT NULL,
				"description" VARCHAR(250) NOT NULL,
				"user_type" VARCHAR(250) NOT NULL
			)
		');
			Schema::table('previous_plan', function (Blueprint $table) {
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
        Schema::dropIfExists('previous_plan');
    }
}
