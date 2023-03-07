<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmailVerificationToUserTable extends Migration
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
                ADD COLUMN "verified" BOOLEAN NOT NULL DEFAULT FALSE,
                ADD COLUMN "email_token" UUID DEFAULT gen_random_uuid()
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
        	ALTER TABLE "users"
				DROP COLUMN IF EXISTS "verified",
				DROP COLUMN IF EXISTS "email_token"
			;
        ');
    }
}
