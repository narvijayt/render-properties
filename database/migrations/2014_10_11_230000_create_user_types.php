<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		DB::statement('CREATE TYPE "user_title_type" AS ENUM (
			\'Mr\',
			\'Ms\',
			\'Dr\'
		)');

		DB::statement('CREATE TYPE "config_id_type" AS ENUM (
			\'main\'
		)');

		DB::statement('CREATE TYPE "config_crypt_type" AS ENUM (
			\'bf\',
			\'md5\',
			\'xdes\',
			\'des\'
		)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		DB::statement('DROP TYPE IF EXISTS "user_title_type"');
		DB::statement('DROP TYPE IF EXISTS "config_id_type"');
		DB::statement('DROP TYPE IF EXISTS "config_crypt_type"');
    }
}
