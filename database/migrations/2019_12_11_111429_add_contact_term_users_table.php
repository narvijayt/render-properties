<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContactTermUsersTable extends Migration
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
            ADD COLUMN "contact_term" BOOLEAN DEFAULT FALSE
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
            DROP COLUMN IF EXISTS "contact_term", 
      ');
    }
}
