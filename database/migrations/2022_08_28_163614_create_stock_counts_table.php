<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockCountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_counts', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            // item id
            $table->biginteger('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('item');
            $table->string('item_name');
            $table->string('barcode',100);
            $table->float('quantity');

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
        Schema::dropIfExists('stock_counts');
    }
}
