<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeBarcodeFieldNullableToSalesDetailNewLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('sales_detail_new_logs', function (Blueprint $table) {
            $table->dropForeign('sales_detail_new_logs_barcode_id_foreign');
            $table->unsignedBigInteger('barcode_id')->nullable()->change();
            $table->foreign('barcode_id')->references('id')->on('purchase_item_barcodes');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('sales_detail_new_logs', function (Blueprint $table) {
            $table->dropForeign('sales_detail_new_logs_barcode_id_foreign');
            $table->unsignedBigInteger('barcode_id')->nullable(false)->change();
            $table->foreign('barcode_id')->references('id')->on('purchase_item_barcodes');
        });
        Schema::enableForeignKeyConstraints();
        
    }
}
