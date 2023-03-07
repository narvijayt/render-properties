<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLocationDataToUsersDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
        	ALTER TABLE "user_details"
				ADD COLUMN "city" VARCHAR(250) DEFAULT NULL CHECK ("city" IS NULL OR "city" <> \'\'),
				ADD COLUMN "state" VARCHAR(5) DEFAULT NULL CHECK ("state" IS NULL OR ("state" <> \'\' AND "state" = upper("state"))),
				ADD COLUMN "zip" VARCHAR(10) DEFAULT NULL CHECK ("zip" IS NULL OR "zip" ~ \'[0-9]{5}|[0-9]{5}-[0-9]{4}\')
			;
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
        	ALTER TABLE "user_details"
				DROP COLUMN IF EXISTS "city",
				DROP COLUMN IF EXISTS "state",
				DROP COLUMN IF EXISTS "zip"
			;
        ');
    }
}
