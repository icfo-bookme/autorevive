<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePaymentDueTypeFloatToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->float('payment_due',8,2)->default(0)->change();
            $table->float('is_shipment_charge_applied',8,2)->nullable(false)->default(0)->change();
            $table->boolean('is_due_paid')->default(1)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('payment_due')->default(0)->change();
            $table->integer('is_shipment_charge_applied')->nullable()->change();
            $table->integer('is_due_paid')->default(1)->change();
        });
    }
}
