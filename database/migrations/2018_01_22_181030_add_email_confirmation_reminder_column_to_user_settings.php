<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmailConfirmationReminderColumnToUserSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	DB::statement('
    		ALTER TABLE "user_settings"
    			ADD COLUMN IF NOT EXISTS "email_receive_email_confirmation_reminders" BOOLEAN DEFAULT TRUE;
    	');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		DB::statement('
    		ALTER TABLE "user_settings"
    			DROP COLUMN IF EXISTS "email_receive_email_confirmation_reminders";
    	');
    }
}
