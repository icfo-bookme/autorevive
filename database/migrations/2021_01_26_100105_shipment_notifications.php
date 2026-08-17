<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShipmentNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('message');
            $table->text('redirect_link');
            $table->boolean('is_seen')->nullable();
            $table->unsignedBigInteger('notification_by');
            $table->unsignedBigInteger('notification_to');
            $table->boolean('soft_delete')->default(0);
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
        Schema::dropIfExists('shipment_notifications');
    }
}
