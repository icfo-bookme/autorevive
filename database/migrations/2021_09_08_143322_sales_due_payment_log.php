<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SalesDuePaymentLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_due_payment_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sales_id')->unsigned();
            $table->foreign('sales_id')->references('id')->on('sales');
            $table->double('paid_amount', 12, 2);
            $table->string('collected_by',50);
            $table->datetime('due_collected_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_due_payment_log');
    }
}
