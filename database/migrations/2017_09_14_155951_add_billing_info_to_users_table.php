<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBillingInfoToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
        	ALTER TABLE "users"
        		ADD COLUMN "billing_first_name" VARCHAR(255) DEFAULT NULL,
        		ADD COLUMN "billing_last_name" VARCHAR(255) DEFAULT NULL,
        		ADD COLUMN "billing_company" VARCHAR(255) DEFAULT NULL,
        		ADD COLUMN "billing_address_1" VARCHAR(255) DEFAULT NULL,
        		ADD COLUMN "billing_address_2" VARCHAR(255) DEFAULT NULL,
        		ADD COLUMN "billing_locality" VARCHAR(255) DEFAULT NULL,
        		ADD COLUMN "billing_region" VARCHAR(255) DEFAULT NULL,
        		ADD COLUMN "billing_postal_code" VARCHAR(255) DEFAULT NULL
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
        	ALTER TABLE "users"
        		DROP COLUMN IF EXISTS "billing_first_name",
        		DROP COLUMN IF EXISTS "billing_last_name",
        		DROP COLUMN IF EXISTS "billing_company",
        		DROP COLUMN IF EXISTS "billing_address_1",
        		DROP COLUMN IF EXISTS "billing_address_2",
        		DROP COLUMN IF EXISTS "billing_locality",
        		DROP COLUMN IF EXISTS "billing_region",
        		DROP COLUMN IF EXISTS "billing_postal_code"
        ');
    }
}
