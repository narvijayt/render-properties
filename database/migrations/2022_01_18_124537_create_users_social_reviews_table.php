<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersSocialReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_social_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('userid')->nullable(false);
            $table->string('zillow_screenname','555')->nullable(true);
            $table->longText('facebook_embedded_review')->nullable(true);
            $table->longText('yelp_embedded_review')->nullable(true);
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
        Schema::dropIfExists('users_social_reviews');
    }
}
