<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRefinanceLeadNotificationRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refinance_lead_notification_relationships', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('refinance_form_id');
            $table->integer('agent_id');
            $table->string('notification_type', 55); // Paid and Unpaid LO
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
        Schema::dropIfExists('refinance_lead_notification_relationships');
    }
}
