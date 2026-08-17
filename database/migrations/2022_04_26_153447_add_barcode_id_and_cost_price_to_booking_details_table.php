<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBarcodeIdAndCostPriceToBookingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_details', function (Blueprint $table) {
            //purchase item barcodes id
            $table->biginteger('barcode_id')->unsigned()->after('product_id')->nullable();
            $table->foreign('barcode_id')->references('id')->on('purchase_item_barcodes');
            $table->double('cost_price',12,2)->after('total_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_details', function (Blueprint $table) {
            $table->dropForeign(['barcode_id']);
            $table->dropColumn('barcode_id');
            $table->dropColumn('cost_price');
        });
    }
}
