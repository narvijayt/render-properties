<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomePageBuilderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_page_builder', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('userId');
            $table->text('banner')->nullable();
            $table->text('section_1')->nullable();
            $table->text('section_2')->nullable();
            $table->text('section_3')->nullable();
            $table->text('section_4')->nullable();
            $table->text('section_5')->nullable();
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
        Schema::dropIfExists('home_page_builder');
    }
}
