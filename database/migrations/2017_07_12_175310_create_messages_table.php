<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            CREATE TABLE "conversations" (
                "conversation_id" BIGSERIAL NOT NULL PRIMARY KEY,
                "user_id" BIGINT NOT NULL REFERENCES "users" ("user_id") ON DELETE CASCADE ON UPDATE CASCADE,
                "conversation_title" VARCHAR(255) NOT NULL CHECK ("conversation_title" <> \'\'),
                "created_at" TIMESTAMP(0) without TIME ZONE,
                "updated_at" TIMESTAMP(0) without TIME ZONE,
                "deleted_at" TIMESTAMP(0) without TIME ZONE
            )
        ');
        DB::statement('
            CREATE TABLE "messages" (
                "message_id" BIGSERIAL NOT NULL PRIMARY KEY,
                "conversation_id" BIGINT NOT NULL REFERENCES "conversations" ("conversation_id") ON DELETE CASCADE ON UPDATE CASCADE,
                "user_id" BIGINT NOT NULL REFERENCES "users" ("user_id") ON DELETE CASCADE ON UPDATE CASCADE,
                "message_text" TEXT NOT NULL,
                "created_at" TIMESTAMP(0) without TIME ZONE,
                "updated_at" TIMESTAMP(0) without TIME ZONE,
                "deleted_at" TIMESTAMP(0) without TIME ZONE
            )
        ');
        DB::statement('
            CREATE TABLE "conversation_user" (
                "conversation_id" BIGINT NOT NULL REFERENCES "conversations" ("conversation_id") ON DELETE CASCADE ON UPDATE CASCADE,
                "user_id" BIGINT NOT NULL REFERENCES "users" ("user_id") ON DELETE CASCADE ON UPDATE CASCADE,
                "archived" TIMESTAMP(0) without TIME ZONE DEFAULT NULL,
                "last_read" TIMESTAMP(0) without TIME ZONE DEFAULT NULL
            )
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP TABLE "conversation_user"');
        DB::statement('DROP TABLE "messages"');
        DB::statement('DROP TABLE "conversations"');
    }
}
