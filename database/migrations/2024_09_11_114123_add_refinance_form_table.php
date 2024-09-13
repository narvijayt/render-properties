<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRefinanceFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refinance_form', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type_of_property', 55)->nullable();
            $table->string('estimate_credit_score', 55)->nullable();
            $table->string('how_property_used', 55)->nullable();
            $table->string('have_second_mortgage', 20)->nullable();
            $table->string('borrow_additional_cash', 55)->nullable();
            $table->string('employment_status', 55)->nullable();
            $table->string('bankruptcy_shortscale_foreclosure', 20)->nullable();
            $table->string('proof_of_income', 20)->nullable();
            $table->string('average_monthly_income', 55)->nullable();
            $table->string('average_monthly_expenses', 55)->nullable();
            $table->string('currently_have_fha_loan', 20)->nullable();
            $table->string('firstName', 55);
            $table->string('lastName', 55);
            $table->string('email', 255)->nullable();
            $table->string('phone_number', 55);
            $table->string('street_address', 110)->nullable();
            $table->string('street_address_line_2', 110)->nullable();
            $table->string('city', 55);
            $table->string('state', 55);
            $table->string('postal_code', 30);
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
        Schema::dropIfExists('refinance_form');
    }
}
