<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserActivityToUserTable extends Migration
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
				ADD COLUMN "last_activity" TIMESTAMP(0) WITHOUT TIME ZONE;
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
        		DROP COLUMN IF EXISTS "last_activity";
        ');
    }
}
