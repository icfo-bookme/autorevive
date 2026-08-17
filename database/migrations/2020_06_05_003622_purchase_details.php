<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PurchaseDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->biginteger('purchase_id')->unsigned();
            $table->foreign('purchase_id')->references('id')->on('purchase');

            // item id
            $table->biginteger('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('item');

            $table->double('cost_price', 12, 2);
            $table->double('sales_price',12,2);
            $table->double('mrp',12,2);
            $table->integer('quantity');
            $table->string('uom',50);
            $table->date('expired_date');
            $table->string('barcode',100);
            
            // others
            $table->string('created_by',50);
            $table->string('updated_by',50);
            $table->boolean('soft_delete')->default(0)->comment("0=not deleted | 1=deleted");
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
        Schema::dropIfExists('purchase_details');
    }
}
