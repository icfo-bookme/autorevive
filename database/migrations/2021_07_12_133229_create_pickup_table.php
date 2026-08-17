<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePickupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pickup', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders');
            
            $table->date('pickup_date');
            $table->string('pickup_time',50);
            $table->timestamp('completed_at')->nullable();
            $table->string('completed_by',50);
            $table->string('created_by',50);
            $table->string('updated_by',50);

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
        Schema::dropIfExists('pickup');
    }
}
