<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrepaidPeriodEndsAtColumnToUsersTable extends Migration
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
				ADD COLUMN "prepaid_period_ends_at" TIMESTAMP(0) DEFAULT NULL;
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
				DROP COLUMN "prepaid_period_ends_at";
		');
    }
}
