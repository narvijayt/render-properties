<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id');
            $table->string('plan_id',155);
            $table->enum('payment_method', ['Stripe']);
            $table->string('stripe_subscription_id', 155);
            $table->string('stripe_payment_intent_id', 155);
            $table->string('paid_amount', 155);
            $table->string('currency', 155);
            $table->string('plan_interval', 155);
            $table->integer('plan_interval_count')->default(1);
            $table->string('customer_name', 155);
            $table->string('customer_email', 155);
            $table->dateTime('plan_period_start', 155);
            $table->dateTime('plan_period_end', 155);
            $table->string('status', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_subscriptions');
    }
}
