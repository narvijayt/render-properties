<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchPurchaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		DB::statement('
			CREATE TYPE "match_purchase_type" AS ENUM (
				\'complimentary\',
				\'purchased\'
			)
		');

        DB::statement('
        	CREATE TABLE "match_purchases" (
        		"match_purchase_id" BIGSERIAL NOT NULL PRIMARY KEY,
        		"user_id" BIGINT NOT NULL REFERENCES "users" ("user_id") ON DELETE CASCADE ON UPDATE CASCADE,
        		"type" "match_purchase_type" NOT NULL,
        		"quantity" INT NOT NULL,
        		"braintree_transaction_id" VARCHAR(100),
        		"created_at" TIMESTAMP(0) without TIME ZONE,
    			"updated_at" TIMESTAMP(0) without TIME ZONE,
    			UNIQUE("braintree_transaction_id")
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
    	DB::statement('DROP TABLE IF EXISTS "match_purchases"');
		DB::statement('DROP TYPE "match_purchase_type"');
    }
}
