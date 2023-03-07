<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmailSettingsToSettingsTable extends Migration
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
        		ADD COLUMN "email_receive_conversation_messages" BOOLEAN DEFAULT TRUE,
        		ADD COLUMN "email_receive_match_requests" BOOLEAN DEFAULT TRUE,
        		ADD COLUMN "email_receive_match_suggestions" BOOLEAN DEFAULT TRUE,
        		ADD COLUMN "email_receive_review_messages" BOOLEAN DEFAULT TRUE,
        		DROP COLUMN IF EXISTS "notify_email_messages";
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
        		DROP COLUMN IF EXISTS "email_receive_conversation_messages",
        		DROP COLUMN IF EXISTS "email_receive_match_requests",
        		DROP COLUMN IF EXISTS "email_receive_match_suggestions",
        		DROP COLUMN IF EXISTS "email_receive_review_messages",
        		ADD COLUMN "notify_email_messages" BOOLEAN DEFAULT TRUE;
        ');
    }
}
