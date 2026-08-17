<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUnitpriceFieldToSalesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_details', function (Blueprint $table) {
            $table->float('unit_price',12,2)->default(0)->after('quantity');
            $table->float('price',12,2)->comment("total price,quan x unit_price")->change();
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
            $table->dropColumn('unit_price');
            $table->float('price',12,2)->change();
        });
    }
}
