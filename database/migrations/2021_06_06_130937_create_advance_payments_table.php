<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvancePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advance_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('booking_id')->unsigned();
            $table->foreign('booking_id')->references('id')->on('bookings'); 
            $table->biginteger('payment_method_id')->unsigned();
            $table->foreign('payment_method_id')->references('id')->on('payment_method'); 
            $table->double('paid_amount',12,2)->nullable();          
            $table->double('payable_amount',12,2)->nullable();          
            $table->string('payment_collected_by',50)->nullable();
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
        Schema::dropIfExists('advance_payments');
    }
}
