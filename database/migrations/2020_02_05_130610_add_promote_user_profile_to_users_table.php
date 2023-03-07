<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPromoteUserProfileToUsersTable extends Migration
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
        	ADD COLUMN "promote_profile" BOOLEAN DEFAULT FALSE
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
        		DROP COLUMN "promote_profile"
        ');
    }
}
