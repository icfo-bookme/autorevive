<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMinimumPriceFieldToItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item', function (Blueprint $table) {
            $table->double('minimum_price',12,2)->nullable()->after('cost_price');
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
        Schema::table('item', function (Blueprint $table) {
            $table->dropColumn('minimum_price');
            $table->float('sales_price',12,2)->nullable()->change();
        });
    }
}
