<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPreviousStateCityToPreviousPlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            ALTER TABLE "previous_plan"
            ADD COLUMN "previous_state" VARCHAR(255) DEFAULT NULL,
            ADD COLUMN "previous_city" VARCHAR(255) DEFAULT NULL,
            ADD COLUMN "previous_additional_state" VARCHAR(255) DEFAULT NULL,
            ADD COLUMN "previous_additional_city" VARCHAR(255) DEFAULT NULL
            
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
            ALTER TABLE "previous_plan"
              DROP COLUMN IF EXISTS "previous_state",
              DROP COLUMN IF EXISTS "previous_city",
              DROP COLUMN IF EXISTS "previous_additional_state",
              DROP COLUMN IF EXISTS "previous_additional_city";
        ');
    }
}
