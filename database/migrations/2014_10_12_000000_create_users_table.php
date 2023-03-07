<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	DB::statement('
    		CREATE TABLE "users" (
				"user_id"  BIGSERIAL PRIMARY KEY,
				"username" VARCHAR(250) NOT NULL UNIQUE,
				"email" VARCHAR(250) NOT NULL UNIQUE,
				"password" VARCHAR(250) NOT NULL,
				"active" BOOLEAN NOT NULL DEFAULT TRUE,
				"title" "user_title_type" NOT NULL,
				"first_name" VARCHAR(250) NOT NULL CHECK ("first_name" IS NULL OR "first_name" <> \'\'),
				"last_name" VARCHAR(250) NOT NULL CHECK ("last_name" IS NULL OR "last_name" <> \'\')
			)
    	');

        Schema::table('users', function (Blueprint $table) {
            $table->rememberToken();
            $table->timestamps();
        });

//		DB::statement('ALTER TABLE "users" OWNER TO "rt_admin";');
//		DB::statement('GRANT SELECT ON "users" TO "rtc_user";');
    }

    /**
     * Reverse the migrations.
     *
     * @return voidart
     */
    public function down()
    {
		DB::statement('DROP TABLE "users"');
    }
}
