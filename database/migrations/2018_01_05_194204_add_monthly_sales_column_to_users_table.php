<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMonthlySalesColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		DB::statement('
			ALTER TABLE "users"
			  ADD COLUMN "monthly_sales" SMALLINT DEFAULT NULL
        ');

        DB::statement('
        	WITH averages AS (
				SELECT
				  user_id,
				  ROUND(AVG(sales_total)) as sales
				FROM sales_per_month
				GROUP BY user_id
			)
			UPDATE users
			SET monthly_sales = averages.sales
			FROM averages
			WHERE users.user_id = averages.user_id
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
			ALTER TABLE "users"
				DROP COLUMN IF EXISTS "monthly_sales"
        ');
    }
}
