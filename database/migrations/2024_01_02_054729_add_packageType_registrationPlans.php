<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPackageTypeRegistrationPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('registration_plans', function (Blueprint $table) {
            //
            $table->enum('packageType',['lender','vendor'])->after("planId")->default('lender');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registration_plans', function (Blueprint $table) {
            //
            $table->dropColumn("packageType");
        });
    }
}
