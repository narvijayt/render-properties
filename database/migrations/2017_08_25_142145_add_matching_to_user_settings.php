<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMatchingToUserSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		DB::statement(<<<'EOL'
ALTER TABLE "user_settings"
	ADD COLUMN "match_by_states" TEXT[],
	ADD COLUMN "match_by_exp_min" INTEGER DEFAULT NULL CHECK ("match_by_exp_min" IS NULL OR "match_by_exp_min" >= 0),
	ADD COLUMN "match_by_exp_max" INTEGER DEFAULT NULL CHECK ("match_by_exp_max" IS NULL OR "match_by_exp_max" >= 0),
	ADD COLUMN "match_by_sales_total_min" INTEGER DEFAULT NULL CHECK ("match_by_sales_total_min" IS NULL OR "match_by_sales_total_min" >= 0),
	ADD COLUMN "match_by_sales_total_max" INTEGER DEFAULT NULL CHECK ("match_by_sales_total_max" IS NULL OR "match_by_sales_total_max" >= 0),
	ADD COLUMN "match_by_sales_value_min" NUMERIC(20,2) DEFAULT NULL CHECK ("match_by_sales_value_min" IS NULL OR "match_by_sales_value_min" >= 0.00),
	ADD COLUMN "match_by_sales_value_max" NUMERIC(20,2) DEFAULT NULL CHECK ("match_by_sales_value_max" IS NULL OR "match_by_sales_value_max" >= 0.00),
	ADD CHECK ("match_by_exp_min" IS NULL OR "match_by_exp_max" IS NULL OR "match_by_exp_min" <= "match_by_exp_max"),
	ADD CHECK ("match_by_sales_total_min" IS NULL OR "match_by_sales_total_max" IS NULL OR "match_by_sales_total_min" <= "match_by_sales_total_max"),
	ADD CHECK ("match_by_sales_value_min" IS NULL OR "match_by_sales_value_max" IS NULL OR "match_by_sales_value_min" <= "match_by_sales_value_max")
EOL
		);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		DB::statement(<<<'EOL'
ALTER TABLE "user_settings"
	DROP COLUMN "match_by_states",
	DROP COLUMN "match_by_exp_min",
	DROP COLUMN "match_by_exp_max",
	DROP COLUMN "match_by_sales_total_min",
	DROP COLUMN "match_by_sales_total_max",
	DROP COLUMN "match_by_sales_value_min",
	DROP COLUMN "match_by_sales_value_max"
EOL
		);
    }
}
