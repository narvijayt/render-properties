<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('lo_matching_acknowledged', 20)->nullable()->after('contact_me_for_match');
            $table->string('referral_fee_acknowledged', 20)->nullable()->after('lo_matching_acknowledged');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('lo_matching_acknowledged');
            $table->dropColumn('referral_fee_acknowledged');
        });
    }
}
