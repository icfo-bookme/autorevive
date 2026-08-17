<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->bigIncrements('id');

            // purchase item barcodes id
            $table->biginteger('item_barcodes_id')->unsigned();
            $table->foreign('item_barcodes_id')->references('id')->on('purchase_item_barcodes');
            // item id
            $table->biginteger('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('item');

            $table->string('barcode',100);
            $table->double('cost_price',12,2);
            $table->float('quantity');
            $table->string('uom',50);
            $table->string('created_by',50)->nullable();
            $table->string('updated_by',50)->nullable();
            $table->boolean('soft_delete')->default(0);
            $table->boolean('duplicate_flag')->default(0);
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
        Schema::dropIfExists('stocks');
    }
}
