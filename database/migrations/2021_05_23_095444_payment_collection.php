<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PaymentCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_collection', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders');           
            $table->biginteger('payment_method_id')->unsigned();
            $table->foreign('payment_method_id')->references('id')->on('payment_method');           
            $table->string('invoice_amount')->nullable()->comment('subtotal');          
            $table->double('total_amount',12,2)->nullable()->comment('subtotal with shipping cost');          
            $table->string('payment_collected_by')->nullable();
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
        Schema::dropIfExists('payment_collection');
    }
}
