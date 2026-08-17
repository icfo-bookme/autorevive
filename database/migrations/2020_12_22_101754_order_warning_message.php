<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderWarningMessage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_warning_messege', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('delivery_man_id')->unsigned();
            $table->biginteger('order_id')->unsigned();
            $table->datetime('deadline');
            $table->string('team_lead');
            $table->integer('init_warning')->default(0);

            $table->boolean('soft_delete')->default(0);
            $table->timestamps();

            $table->foreign('delivery_man_id')->references('id')->on('users');
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_warning_messege');
    }
}
