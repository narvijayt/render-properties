<?php

use Silber\Bouncer\Database\Models;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBouncerTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	DB::statement('
    		CREATE TABLE "abilities" (
    			"id" BIGSERIAL NOT NULL PRIMARY KEY,
    			"name" VARCHAR(150),
    			"title" VARCHAR(255) DEFAULT NULL,
    			"entity_id" BIGINT DEFAULT NULL,
    			"entity_type" VARCHAR(150) DEFAULT NULL,
    			"only_owned" BOOLEAN DEFAULT FALSE,
    			"created_at" TIMESTAMP(0) without TIME ZONE,
                "updated_at" TIMESTAMP(0) without TIME ZONE,
                UNIQUE("name", "entity_id", "entity_type", "only_owned")
    		);
    	');

    	DB::statement('
    		CREATE INDEX "abilities_unique_index" ON "abilities" ("name", "entity_id", "entity_type", "only_owned");
    	');
//        Schema::create(Models::table('abilities'), function (Blueprint $table) {
//            $table->increments('id');
//            $table->string('name', 150);
//            $table->string('title')->nullable();
//            $table->integer('entity_id')->unsigned()->nullable();
//            $table->string('entity_type', 150)->nullable();
//            $table->boolean('only_owned')->default(false);
//            $table->timestamps();
//
//            $table->unique(
//                ['name', 'entity_id', 'entity_type', 'only_owned'],
//                'abilities_unique_index'
//            );
//        });

		DB::statement('
			CREATE TABLE "roles" (
				"id" BIGSERIAL NOT NULL PRIMARY KEY,
				"name" VARCHAR(255),
				"title" VARCHAR(255) DEFAULT NULL,
				"level" INTEGER DEFAULT NULL,
				"created_at" TIMESTAMP(0) without TIME ZONE,
                "updated_at" TIMESTAMP(0) without TIME ZONE,
                UNIQUE("name")
			);
		');

//        Schema::create(Models::table('roles'), function (Blueprint $table) {
//            $table->increments('id');
//            $table->string('name')->unique();
//            $table->string('title')->nullable();
//            $table->integer('level')->unsigned()->nullable();
//            $table->timestamps();
//        });

		DB::statement('
			CREATE TABLE "assigned_roles" (
				"role_id" BIGINT NOT NULL REFERENCES "roles" ("id") ON UPDATE CASCADE ON DELETE CASCADE,
				"entity_id" BIGINT,
				"entity_type" VARCHAR(255) DEFAULT NULL
			);
		');

		DB::statement('
    		CREATE INDEX "assigned_roles_role_id_index" ON "assigned_roles" ("role_id");
    	');

//        Schema::create(Models::table('assigned_roles'), function (Blueprint $table) {
//            $table->integer('role_id')->unsigned()->index();
//            $table->morphs('entity');
//
//            $table->foreign('role_id')->references('id')->on(Models::table('roles'))
//                  ->onUpdate('cascade')->onDelete('cascade');
//        });

		DB::statement('
			CREATE TABLE "permissions" (
				"ability_id" BIGINT NOT NULL REFERENCES "abilities" ("id") ON UPDATE CASCADE ON DELETE CASCADE,
				"entity_id" BIGINT,
				"entity_type" VARCHAR(255) DEFAULT NULL,
				"forbidden" BOOLEAN DEFAULT FALSE
			);
		');

		DB::statement('
    		CREATE INDEX "permissions_ability_id_index" ON "permissions" ("ability_id");
    	');

//        Schema::create(Models::table('permissions'), function (Blueprint $table) {
//            $table->integer('ability_id')->unsigned()->index();
//            $table->morphs('entity');
//            $table->boolean('forbidden')->default(false);
//
//            $table->foreign('ability_id')->references('id')->on(Models::table('abilities'))
//                  ->onUpdate('cascade')->onDelete('cascade');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('assigned_roles');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('abilities');
    }
}
