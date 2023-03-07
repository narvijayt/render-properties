<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBraintreeTables extends Migration
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
				ADD COLUMN "braintree_id" VARCHAR(255) DEFAULT NULL,
				ADD COLUMN "paypal_email" VARCHAR(255) DEFAULT NULL,
				ADD COLUMN "card_brand" VARCHAR(255) DEFAULT NULL,
				ADD COLUMN "card_last_four" VARCHAR(255) DEFAULT NULL,
				ADD COLUMN "trial_ends_at" TIMESTAMP(0) without TIME ZONE DEFAULT NULL
        ');

        DB::statement('
        	CREATE TABLE "subscriptions" (
        		"id" BIGSERIAL NOT NULL PRIMARY KEY,
        		"user_id" BIGINT REFERENCES "users" ("user_id") ON DELETE CASCADE ON UPDATE CASCADE,
        		"name" VARCHAR(255),
        		"braintree_id" VARCHAR(255),
        		"braintree_plan" VARCHAR(255),
        		"quantity" INTEGER,
				"trial_ends_at" TIMESTAMP(0) without TIME ZONE DEFAULT NULL,
				"ends_at" TIMESTAMP(0) without TIME ZONE DEFAULT NULL,
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
        DB::statement('
        	DROP TABLE IF EXISTS "subscriptions"
        ');

        DB::statement('
        	ALTER TABLE "users"
        		DROP COLUMN IF EXISTS "braintree_id",
        		DROP COLUMN IF EXISTS "paypal_email",
        		DROP COLUMN IF EXISTS "card_brand",
        		DROP COLUMN IF EXISTS "card_last_four",
        		DROP COLUMN IF EXISTS "trial_ends_at"
        ');
    }
}
