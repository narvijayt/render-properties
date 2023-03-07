<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EntrustSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        DB::statement('
            CREATE TABLE "roles" (
                "id" BIGSERIAL NOT NULL PRIMARY KEY,
                "name" VARCHAR(255) NOT NULL UNIQUE,
                "display_name" VARCHAR(255),
                "description" VARCHAR(255),
                "created_at" TIMESTAMP(0) without TIME ZONE,
                "updated_at" TIMESTAMP(0) without TIME ZONE
            )
        ');

        DB::statement('
            CREATE TABLE "role_user" (
                "user_id" BIGINT NOT NULL REFERENCES "users" ("user_id") ON DELETE CASCADE ON UPDATE CASCADE,
                "role_id" BIGINT NOT NULL REFERENCES "roles" ("id") ON DELETE CASCADE ON UPDATE CASCADE,
                PRIMARY KEY ("user_id", "role_id")
            )
        ');

        DB::statement('
            CREATE TABLE "permissions" (
                "id" BIGSERIAL NOT NULL PRIMARY KEY,
                "name" VARCHAR(255) NOT NULL UNIQUE,
                "display_name" VARCHAR(255),
                "description" VARCHAR(255),
                "created_at" TIMESTAMP(0) without TIME ZONE,
                "updated_at" TIMESTAMP(0) without TIME ZONE
            )
        ');

        DB::statement('
            CREATE TABLE "permission_role" (
                "permission_id" BIGINT NOT NULL REFERENCES "permissions" ("id") ON DELETE CASCADE ON UPDATE CASCADE,
                "role_id" BIGINT NOT NULL REFERENCES "roles" ("id") ON DELETE CASCADE ON UPDATE CASCADE,
                PRIMARY KEY ("permission_id", "role_id")
            )
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        DB::statement('DROP TABLE "permission_role"');
        DB::statement('DROP TABLE "permissions"');
        DB::statement('DROP TABLE "role_user"');
        DB::statement('DROP TABLE "roles"');
    }
}
