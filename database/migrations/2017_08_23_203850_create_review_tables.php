<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Enums;
use Illuminate\Database\Migrations\Migration;

class CreateReviewTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
			CREATE TYPE "review_status_type" AS ENUM (
				\'accepted\',
				\'rejected\',
				\'unseen\',
				\'overridden\'
			)
		');
        DB::statement('
            CREATE TABLE IF NOT EXISTS "reviews" (
                "review_id" UUID NOT NULL PRIMARY KEY DEFAULT gen_random_uuid(),
                "reviewer_user_id" BIGINT REFERENCES "users" ("user_id"),
                "subject_user_id" BIGINT REFERENCES "users" ("user_id") ON DELETE CASCADE ON UPDATE CASCADE,
                "message" VARCHAR(1000) NOT NULL,
                "rating" FLOAT NOT NULL,
                "status" "review_status_type" DEFAULT NULL,
                "reject_message" VARCHAR(1000),
				"created_at" TIMESTAMP(0) without TIME ZONE,
				"rejected_at" TIMESTAMP(0) without TIME ZONE,
				"updated_at" TIMESTAMP (0) without TIME ZONE,
				"deleted_at" TIMESTAMP(0) without TIME ZONE,
				UNIQUE ("reviewer_user_id", "subject_user_id")
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
        DB::statement('DROP TABLE IF EXISTS "reviews"');
        DB::statement('DROP TYPE "review_status_type"');
    }
}
