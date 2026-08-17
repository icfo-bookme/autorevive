<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesDetailNewLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_detail_new_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            // sales_log id
            $table->biginteger('sales_log_id')->unsigned();   
            $table->foreign('sales_log_id')->references('id')->on('sales_new_logs');
            // sales_details id
            $table->biginteger('sale_detail_id');   
            // item id
            $table->biginteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('item');
            // barcode id
            $table->biginteger('barcode_id')->unsigned();
            $table->foreign('barcode_id')->references('id')->on('purchase_item_barcodes');

            $table->string('product_name');
            $table->double('quantity',8,2);
            $table->double('unit_price',12,2);
            $table->double('price',12,2);
            $table->double('cost_price',12,2);
            $table->double('regular_price',12,2);
            $table->string('details_created_by',50);
            $table->string('details_updated_by',50);
            $table->boolean('soft_delete');
            $table->string('created_by',50);
            
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
        Schema::dropIfExists('sales_detail_new_logs');
    }
}
