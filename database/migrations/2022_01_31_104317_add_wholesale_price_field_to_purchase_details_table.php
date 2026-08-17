<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWholesalePriceFieldToPurchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_details', function (Blueprint $table) {
            $table->double('wholesale_price',12,2)->nullable()->after('sales_price');
            $table->float('sales_price',12,2)->nullable()->comment('offer_price')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_details', function (Blueprint $table) {
            $table->dropColumn('wholesale_price');
            $table->float('sales_price',12,2)->change();
        });
    }
}
