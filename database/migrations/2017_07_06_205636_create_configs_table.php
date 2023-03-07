<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		DB::statement('
			CREATE TABLE "configs" (
				"config_id" BIGSERIAL NOT NULL PRIMARY KEY,
				"crypt_algo" "config_crypt_type" NOT NULL,
				"crypt_iter" INTEGER NOT NULL CHECK ("crypt_iter" IS NULL OR "crypt_iter" >= 0),
				"realtor_active" BOOLEAN NOT NULL DEFAULT TRUE,
				"broker_active" BOOLEAN NOT NULL DEFAULT TRUE,
				"active" BOOLEAN NOT NULL DEFAULT TRUE
			)
		');

//		DB::self::statement('ALTER TABLE "configs" OWNER TO "rtc_admin";');
//		DB::self::statement('GRANT SELECT ON "config" TO "rtc_user"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		DB::statement('DROP TABLE IF EXISTS "configs"');
    }
}
