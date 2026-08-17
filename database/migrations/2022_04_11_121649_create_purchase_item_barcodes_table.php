<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseItemBarcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_item_barcodes', function (Blueprint $table) {
            $table->bigIncrements('id');
            // purchase id
            $table->bigInteger('purchase_id')->unsigned();
            $table->foreign('purchase_id')->references('id')->on('purchase');
            //Purchase detail id
            $table->biginteger('purchase_detail_id')->unsigned();
            $table->foreign('purchase_detail_id')->references('id')->on('purchase_details');
            // item id
            $table->biginteger('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('item');
            $table->string('barcode',100);
            $table->double('regular_price',12,2)->nullable();
            $table->double('sales_price',12,2)->nullable()->comment('Offer price');
            $table->string('barcode_image')->nullable();
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
        Schema::dropIfExists('purchase_item_barcodes');
    }
}
