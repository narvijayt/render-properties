<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_packages', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->bigInteger('userId');
            $table->string('title', 255);
            $table->enum('packageType', ['city','state','usa']);
            $table->decimal('basePrice', 8, 2);
            $table->decimal('addOnPrice', 8, 2)->nullable(true);
            $table->string('priceId');
            $table->string('productId');
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('vendor_packages');
    }
}
