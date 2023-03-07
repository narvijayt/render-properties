<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAvatarRelationToUser extends Migration
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
        		ADD COLUMN "user_avatar_id" BIGINT REFERENCES "user_avatars" ("user_avatar_id")
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
        	ALTER TABLE "users" DROP COLUMN IF EXISTS "user_avatar_id"
        ');
    }
}
