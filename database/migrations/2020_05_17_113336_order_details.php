<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('order_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('order_id')->unsigned();   
            $table->foreign('order_id')->references('id')->on('orders');      
            $table->biginteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('item');
            $table->string('product_name');
            $table->integer('quantity');
            $table->double('unit_price',12,2)->default(0);
            $table->double('price',12,2);
            $table->double('cost_price',12,2)->nullable();
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
        Schema::dropIfExists('order_details');
    }
}
