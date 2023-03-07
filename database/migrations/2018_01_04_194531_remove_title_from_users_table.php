<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveTitleFromUsersTable extends Migration
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
        		DROP COLUMN IF EXISTS "title";
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
        		ADD COLUMN "title" "user_title_type" DEFAULT NULL;
        ');
    }
}
