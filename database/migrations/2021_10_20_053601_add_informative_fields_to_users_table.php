<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInformativeFieldsToUsersTable extends Migration
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
            $table->string('rbc_free_marketing',20)->nullable(true);
            $table->string('open_to_lender_relations',20)->nullable(true);
            $table->string('co_market',20)->nullable(true);
            $table->string('contact_me_for_match',20)->nullable(true);
            $table->text('how_long_realtor')->nullable(true);
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
            $table->dropColumn('rbc_free_marketing');
            $table->dropColumn('open_to_lender_relations');
            $table->dropColumn('co_market');
            $table->dropColumn('contact_me_for_match');
            $table->dropColumn('how_long_realtor');
        });
    }
}
