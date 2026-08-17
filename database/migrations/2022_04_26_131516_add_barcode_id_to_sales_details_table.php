<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBarcodeIdToSalesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_details', function (Blueprint $table) {
            //purchase item barcodes id
            $table->biginteger('barcode_id')->unsigned()->after('product_id')->nullable();
            $table->foreign('barcode_id')->references('id')->on('purchase_item_barcodes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_details', function (Blueprint $table) {
            $table->dropForeign(['barcode_id']);
            $table->dropColumn('barcode_id');
        });
    }
}
