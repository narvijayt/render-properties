<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPhoneAndWebsiteToProfile extends Migration
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
              ADD COLUMN "phone_number" VARCHAR(32) DEFAULT NULL,
              ADD COLUMN "phone_ext" VARCHAR(10) DEFAULT NULL,
              ADD COLUMN "website" VARCHAR(255) DEFAULT NULL;
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
              DROP COLUMN IF EXISTS "phone_number",
              DROP COLUMN IF EXISTS "phone_ext",
              DROP COLUMN IF EXISTS "website";
        ');
    }
}
