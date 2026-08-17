<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_details', function (Blueprint $table) {
            $table->bigIncrements('id');

            // sales id
            $table->biginteger('booking_id')->unsigned();   
            $table->foreign('booking_id')->references('id')->on('bookings');  
           
            //other information
            $table->biginteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('item');
            $table->string('product_name');
            $table->integer('quantity');
            $table->double('unit_price',12,2)->nullable();
            $table->double('total_price',12,2);
            $table->boolean('soft_delete')->default(0);
            $table->string('created_by',50)->nullable();
            $table->string('updated_by',50)->nullable();
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
        Schema::dropIfExists('booking_details');
    }
}
