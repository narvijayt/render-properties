<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBuySellPropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_sell_property', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('firstName', 55);
            $table->string('lastName', 55);
            $table->string('email', 100);
            $table->string('phoneNumber', 55)->nullable();
            $table->string('streetAddress', 110)->nullable();
            $table->string('streetAddressLine2', 110)->nullable();
            $table->string('city', 55);
            $table->string('state', 55);
            $table->string('postal_code', 30);
    
            $table->text('timeToContact')->nullable();
            $table->text('sellUrgency')->nullable();
            $table->string('liveInHouse', 20)->nullable();
            $table->string('freeValuation', 20)->nullable();
            $table->string('offerCommission', 20)->nullable();
            $table->text('whyAreYouSelling')->nullable();
            $table->string('propertyType', 55)->nullable();
    
            $table->string('currentlyOwnOrRent', 30)->nullable();
            $table->string('timeframeForMoving', 30)->nullable();
            $table->string('numberOfBedrooms', 20)->nullable();
            $table->string('numberOfBathrooms', 20)->nullable();
            $table->string('priceRange', 70)->nullable();
            $table->string('preapprovedForMontage', 30)->nullable();
            $table->string('sellHomeBeforeBuy', 30)->nullable();
            $table->text('helpsFindingHomeDesc')->nullable();
    
            $table->string('formPropertyType', 30);
                
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
        Schema::dropIfExists('buy_sell_property');
    }
}
