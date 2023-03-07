<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMeta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      	DB::statement('
    		CREATE TABLE "meta" (
				"id"  BIGSERIAL PRIMARY KEY,
				"page_id" BIGINT UNIQUE NOT NULL,
				"keyword" TEXT NOT NULL,
				"description" TEXT NOT NULL
				);
    	');
    	Schema::table('meta', function (Blueprint $table) {
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       	DB::statement('DROP TABLE "meta"');
    }
}
