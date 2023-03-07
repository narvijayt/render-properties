<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       DB::statement('
        CREATE TABLE "category" (
				"id"  BIGSERIAL PRIMARY KEY,
				"name" VARCHAR(250) NOT NULL
			)
		');
			Schema::table('category', function (Blueprint $table) {
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
       Schema::dropIfExists('category');
    }
}
