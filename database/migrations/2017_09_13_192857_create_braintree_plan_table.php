<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBraintreePlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
        	CREATE TABLE "braintree_plans" (
        		"braintree_plan_id" BIGSERIAL NOT NULL PRIMARY KEY,
        		"name" VARCHAR(255) DEFAULT NULL,
        		"slug" VARCHAR(255) UNIQUE NOT NULL,
        		"braintree_plan" VARCHAR(255) NOT NULL,
        		"cost" DECIMAL NOT NULL,
        		"description" VARCHAR(255),
				"created_at" TIMESTAMP(0) without TIME ZONE,
    			"updated_at" TIMESTAMP(0) without TIME ZONE
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
        DB::statement('DROP TABLE IF EXISTS "braintree_plans"');
    }
}
