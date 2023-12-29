<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRealtorDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('realtor_details', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id');
            $table->integer('require_financial_solution')->default(0);
            $table->integer('require_professional_service')->default(0);
            $table->integer('partnership_with_lender')->default(0);
            $table->integer('partnership_with_vendor')->default(0);
            $table->integer('can_realtor_contact')->default(0);
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
        Schema::dropIfExists('realtor_details');
    }
}
