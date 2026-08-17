<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeQuantityTypeFloatInSaleLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_logs', function (Blueprint $table) {
            $table->float('payment_due',8,2)->default(0)->comment('actual payment_due=(payment_due)-latest(due_paid) from sales_due_payment_log table')->change();
            $table->float('is_shipment_charge_applied',8,2)->nullable(false)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale_logs', function (Blueprint $table) {
            $table->integer('payment_due')->default(0)->comment('actual payment_due=(payment_due)-latest(due_paid) from sales_due_payment_log table')->change();
            $table->integer('is_shipment_charge_applied')->nullable()->change();
        });
    }
}
