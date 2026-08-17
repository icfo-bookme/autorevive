<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Shipment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('shipment', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->biginteger('order_id')->unsigned();
            $table->biginteger('delivery_team_id')->unsigned()->nullable();

            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('delivery_team_id')->references('id')->on('users');

            $table->date('deadline_date');
            $table->string('deadline_time',50);
            $table->integer('priority')->default(1)->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->string('completed_by',50);
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
        Schema::dropIfExists('shipment');
    }
}
