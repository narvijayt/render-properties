<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVendorUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_metadetails', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->bigInteger('userId');
            $table->text('experties')->nullable(true);
            $table->text('special_services')->nullable(true);
            $table->text('service_precautions')->nullable(true);
            $table->integer('connect_realtor')->default(0);
            $table->integer('connect_memebrs')->default(0);
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
        Schema::dropIfExists('vendor_metadetails');
    }
}
