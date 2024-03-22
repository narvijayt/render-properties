<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRealtorRegisterPageBuilderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('realtor_register_page_builder', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('userId');
            $table->text('banner')->nullable();
            $table->text('section_1')->nullable();
            $table->text('section_2')->nullable();
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
        Schema::dropIfExists('realtor_register_page_builder');
    }
}
