<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOldVendorIdToPurchaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase', function (Blueprint $table) {
            //old vendor id
            $table->biginteger('old_vendor_id')->unsigned()->after('vendor_id')->nullable();
            $table->foreign('old_vendor_id')->references('id')->on('vendor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase', function (Blueprint $table) {
            $table->dropForeign(['old_vendor_id']);
            $table->dropColumn('old_vendor_id');
        });
    }
}
