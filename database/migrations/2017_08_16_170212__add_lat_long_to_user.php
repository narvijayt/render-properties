<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLatLongToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        DB::statement('
//          CREATE EXTENSION postgis;
//        ');

        DB::statement('
          ALTER TABLE "users"
            ADD COLUMN "latitude" float  DEFAULT NULL ,
            ADD COLUMN "longitude" float DEFAULT NULL
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        DB::statement('
//          DROP EXTENSION IF EXISTS postgis;
//        ');

        DB::statement('                  
          ALTER TABLE "users" 
            DROP COLUMN IF EXISTS "latitude",
            DROP COLUMN IF EXISTS "longitude"
        ');
    }
}
