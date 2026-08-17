<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsBarcodeToPurchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_details', function (Blueprint $table) {
            $table->boolean('is_barcode')->default(0)->after('soft_delete')->comment('1=barcode available | 0=no barcode');
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
            $table->dropColumn('is_barcode');
        });
    }
}
