<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdjustUserTables extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement(<<<'EOL'
ALTER TABLE "users"
	ADD COLUMN "city" VARCHAR(250) DEFAULT NULL CHECK ("city" IS NULL OR "city" <> ''),
	ADD COLUMN "state" VARCHAR(5) DEFAULT NULL CHECK ("state" IS NULL OR ("state" <> '' AND "state" = upper("state"))),
	ADD COLUMN "zip" VARCHAR(10) DEFAULT NULL CHECK ("zip" IS NULL OR "zip" ~ '[0-9]{5}|[0-9]{5}-[0-9]{4}'),
	ADD COLUMN "register_ts" TIMESTAMP WITH TIME ZONE DEFAULT NULL,
	ADD COLUMN "verify_ts" TIMESTAMP WITH TIME ZONE DEFAULT NULL,
	ADD COLUMN "lock_ts" TIMESTAMP WITH TIME ZONE DEFAULT NULL,
	ADD COLUMN "bio" TEXT DEFAULT NULL CHECK ("bio" IS NULL OR "bio" <> ''),
	ADD COLUMN "prof_license" VARCHAR(250) DEFAULT NULL CHECK ("prof_license" IS NULL OR "prof_license" <> ''),
	ADD COLUMN "firm_name" VARCHAR(250) DEFAULT NULL CHECK ("firm_name" IS NULL OR "firm_name" <> ''),
	ADD COLUMN "career_start" DATE NOT NULL,
	ADD COLUMN "years_of_exp" SMALLINT DEFAULT NULL CHECK ("years_of_exp" IS NULL OR "years_of_exp" >= 0)
EOL
		);
		DB::statement(<<<'EOL'
CREATE TABLE "sales_per_month" (
	"user_sales_id" BIGSERIAL NOT NULL PRIMARY KEY,
	"user_id" BIGINT NOT NULL REFERENCES "users" ("user_id") ON DELETE CASCADE ON UPDATE CASCADE,
	"sales_year" SMALLINT NOT NULL CHECK ("sales_year" >= 1900 OR "sales_year" <= 9999),
	"sales_month" SMALLINT NOT NULL CHECK ("sales_month" >= 1 OR "sales_month" >= 12),
	"sales_total" SMALLINT NOT NULL CHECK ("sales_total" >= 0),
	"sales_value" NUMERIC(20,2) NOT NULL CHECK ("sales_value" >= 0.00),
	"created_at" TIMESTAMP(0) WITHOUT TIME ZONE,
	"updated_at" TIMESTAMP(0) WITHOUT TIME ZONE,
	UNIQUE ("user_id", "sales_year", "sales_month")
)
EOL
		);
		DB::statement('
			DROP TABLE IF EXISTS "realtor_sales"
		');
		DB::statement('
			DROP TABLE IF EXISTS "broker_sales"
		');
		DB::statement('
			DROP TABLE IF EXISTS "realtors"
		');
		DB::statement('
			DROP TABLE IF EXISTS "brokers"
		');
		DB::statement('
			DROP TABLE IF EXISTS "user_details"
		');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement(<<<'EOL'
CREATE TABLE IF NOT EXISTS "user_details" (
	"user_detail_id" BIGSERIAL NOT NULL PRIMARY KEY,
	"user_id" BIGINT NOT NULL REFERENCES "users" ("user_id") ON UPDATE CASCADE ON DELETE CASCADE,
	"register" TIMESTAMP WITH TIME ZONE NOT NULL,
	"verify" TIMESTAMP WITH TIME ZONE,
	"lock" TIMESTAMP WITH TIME ZONE,
	"dob" DATE NOT NULL,
	"created_at" TIMESTAMP(0) WITHOUT TIME ZONE,
	"updated_at" TIMESTAMP(0) WITHOUT TIME ZONE,
	"city" VARCHAR(250) DEFAULT NULL CHECK ("city" IS NULL OR "city" <> ''),
	"state" VARCHAR(5) DEFAULT NULL CHECK ("state" IS NULL OR "state" <> '' AND "state" = upper("state")),
	"zip" VARCHAR(10) DEFAULT NULL CHECK ("zip" IS NULL OR "zip" ~ '[0-9]{5}|[0-9]{5}-[0-9]{4}'),
	"bio" TEXT
)
EOL
		);
		DB::statement(<<<'EOL'
CREATE TABLE IF NOT EXISTS "realtors" (
	"realtor_id" BIGSERIAL NOT NULL PRIMARY KEY,
	"user_id" BIGINT NOT NULL REFERENCES "users" ("user_id") ON UPDATE CASCADE ON DELETE CASCADE,
	"career_start" DATE NOT NULL,
	"years_exp" SMALLINT NOT NULL CHECK ("years_exp" IS NULL OR "years_exp" >= 0),
	"active" BOOLEAN NOT NULL DEFAULT TRUE,
	"created_at" TIMESTAMP(0) WITHOUT TIME ZONE,
	"updated_at" TIMESTAMP(0) WITHOUT TIME ZONE
)
EOL
		);
		DB::statement(<<<'EOL'
CREATE TABLE IF NOT EXISTS "brokers" (
	"broker_id" BIGSERIAL NOT NULL PRIMARY KEY,
	"user_id" BIGINT NOT NULL REFERENCES "users" ("user_id") ON UPDATE CASCADE ON DELETE CASCADE,
	"career_start" DATE NOT NULL,
	"years_exp" SMALLINT NOT NULL CHECK ("years_exp" IS NULL OR "years_exp" >= 0),
	"active" BOOLEAN NOT NULL DEFAULT TRUE,
	"created_at" TIMESTAMP(0) WITHOUT TIME ZONE,
	"updated_at" TIMESTAMP(0) WITHOUT TIME ZONE
)
EOL
		);
		DB::statement(<<<'EOL'
CREATE TABLE IF NOT EXISTS "realtor_sales" (
	"realtor_sales_id" BIGSERIAL NOT NULL PRIMARY KEY,
	"realtor_id" BIGINT NOT NULL REFERENCES "realtors" ("realtor_id") ON UPDATE CASCADE ON DELETE CASCADE,
	"sales_year" SMALLINT NOT NULL CHECK ("sales_year" >= 1900 OR "sales_year" <= 9999),
	"sales_month" SMALLINT NOT NULL CHECK ("sales_month" >= 1 OR "sales_month" >= 12),
	"sales_total" SMALLINT NOT NULL CHECK ("sales_total" >= 0),
	"created_at" TIMESTAMP(0) WITHOUT TIME ZONE,
	"updated_at" TIMESTAMP(0) WITHOUT TIME ZONE,
	UNIQUE ("realtor_id", "sales_year", "sales_month")
)
EOL
		);
		DB::statement(<<<'EOL'
CREATE TABLE IF NOT EXISTS "broker_sales" (
	"broker_sales_id" BIGSERIAL NOT NULL PRIMARY KEY,
	"broker_id" BIGINT NOT NULL REFERENCES "brokers" ("broker_id") ON UPDATE CASCADE ON DELETE CASCADE,
	"sales_year" SMALLINT NOT NULL CHECK ("sales_year" >= 1900 OR "sales_year" <= 9999),
	"sales_month" SMALLINT NOT NULL CHECK ("sales_month" >= 1 OR "sales_month" >= 12),
	"sales_total" SMALLINT NOT NULL CHECK ("sales_total" >= 0),
	"created_at" TIMESTAMP(0) WITHOUT TIME ZONE,
	"updated_at" TIMESTAMP(0) WITHOUT TIME ZONE,
	UNIQUE ("broker_id", "sales_year", "sales_month")
)
EOL
		);
		DB::statement('
			DROP TABLE IF EXISTS "sales_per_month"
		');
		DB::statement(<<<'EOL'
ALTER TABLE "users"
	DROP COLUMN IF EXISTS "city",
	DROP COLUMN IF EXISTS "state",
	DROP COLUMN IF EXISTS "zip",
	DROP COLUMN IF EXISTS "register_ts",
	DROP COLUMN IF EXISTS "verify_ts",
	DROP COLUMN IF EXISTS "lock_ts",
	DROP COLUMN IF EXISTS "bio",
	DROP COLUMN IF EXISTS "prof_license",
	DROP COLUMN IF EXISTS "firm_name",
	DROP COLUMN IF EXISTS "years_of_exp"
EOL
		);
	}
}
