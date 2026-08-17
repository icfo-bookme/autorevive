<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RescheduleReason extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('reschedule_reason', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders');     

            $table->string('reason');
            $table->string('created_by',50);
            $table->string('updated_by',50);
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
        Schema::dropIfExists('reschedule_reason');
    }
}
