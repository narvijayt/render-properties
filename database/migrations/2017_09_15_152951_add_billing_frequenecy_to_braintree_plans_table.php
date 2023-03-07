<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBillingFrequenecyToBraintreePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
    {
        DB::statement('
        	ALTER TABLE "braintree_plans"
        		ADD COLUMN "billing_frequency" SMALLINT
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
        	ALTER TABLE "braintree_plans"
        		DROP COLUMN IF EXISTS "billing_frequency"
        ');
    }}
