<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeEmailDatatypeInBuySellProperty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE "buy_sell_property" ALTER COLUMN "email" TYPE VARCHAR(255);');
        DB::statement('ALTER TABLE "buy_sell_property" ALTER COLUMN "email" DROP NOT NULL;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // This action is irreversible.
    }
}
