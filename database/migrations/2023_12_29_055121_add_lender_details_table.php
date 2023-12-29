<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLenderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('lender_details', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id');
            $table->text('stay_updated')->nullable(true);
            $table->text('handle_challanges')->nullable(true);
            $table->text('unique_experties')->nullable(true);
            $table->integer('partnership_with_realtor')->default(0);
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
        //
        Schema::dropIfExists('lender_details');
    }
}
