<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveEntrustTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		DB::statement('DROP TABLE "permission_role"');
		DB::statement('DROP TABLE "permissions"');
		DB::statement('DROP TABLE "role_user"');
		DB::statement('DROP TABLE "roles"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
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

		DB::table('roles')
			->insert([
				[
					'name' => 'admin',
					'display_name' => 'Admin',
					'description' => 'Admin Role',
					'created_at' => new \DateTime(),
					'updated_at' => new \DateTime()
				],
				[
					'name' => 'realtor',
					'display_name' => 'Realtor',
					'description' => 'Realtor Role',
					'created_at' => new \DateTime(),
					'updated_at' => new \DateTime()
				],
				[
					'name' => 'broker',
					'display_name' => 'Broker',
					'description' => 'Broker Role',
					'created_at' => new \DateTime(),
					'updated_at' => new \DateTime()
				],
			]);

		DB::table('permissions')
			->insert([
				[
					'name' => 'inbox',
					'display_name' => 'Inbox',
					'description' => 'Inbox Permission',
					'created_at' => new \DateTime(),
					'updated_at' => new \DateTime()
				]
			]);

		DB::table('permission_role')
			->insert([
				[
					'permission_id' => DB::table('permissions')->select('id')->where('name', 'inbox')->first()->id,
					'role_id' => DB::table('roles')->select('id')->where('name', 'admin')->first()->id
				],
				[
					'permission_id' => DB::table('permissions')->select('id')->where('name', 'inbox')->first()->id,
					'role_id' => DB::table('roles')->select('id')->where('name', 'realtor')->first()->id
				],
				[
					'permission_id' => DB::table('permissions')->select('id')->where('name', 'inbox')->first()->id,
					'role_id' => DB::table('roles')->select('id')->where('name', 'broker')->first()->id
				]
			]);
    }
}
