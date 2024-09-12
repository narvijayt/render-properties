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
            $table->text('type_of_property')->nullable();
            $table->text('estimate_credit_score')->nullable();
            $table->text('how_property_used')->nullable();
            $table->text('have_second_mortgage')->nullable();
            $table->text('borrow_additional_cash')->nullable();
            $table->text('employment_status')->nullable();
            $table->text('bankruptcy_shortscale_foreclosure')->nullable();
            $table->text('proof_of_income')->nullable();
            $table->text('average_monthly_income')->nullable();
            $table->text('average_monthly_expenses')->nullable();
            $table->text('currently_have_fha_loan')->nullable();
            $table->text('firstName')->nullable();
            $table->text('lastName')->nullable();
            $table->text('email')->nullable();
            $table->text('phone_number')->nullable();
            $table->text('street_address')->nullable();
            $table->text('street_address_line_2')->nullable();
            $table->text('city')->nullable();
            $table->text('state')->nullable();      
            $table->text('postal_code')->nullable();
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
