<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SalesDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         //
        Schema::create('sales_details', function (Blueprint $table) {
            $table->bigIncrements('id');

            // sales id
            $table->biginteger('sales_id')->unsigned();   
            $table->foreign('sales_id')->references('id')->on('sales');     


            // order_id
            $table->biginteger('order_id')->unsigned();   
            $table->foreign('order_id')->references('id')->on('orders');  
           
            //other information
            $table->biginteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('item');
            $table->string('product_name');
            $table->integer('quantity');
            $table->double('price',12,2);
            $table->double('cost_price',12,2)->nullable();
            $table->string('created_by',50)->nullable();
            $table->string('updated_by',50)->nullable();
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
        Schema::dropIfExists('sales_details');
    }
}
