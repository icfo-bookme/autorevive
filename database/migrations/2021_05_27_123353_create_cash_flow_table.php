<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashFlowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_flow', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->date('date');
            $table->string('description');
            $table->string('type',20);
            $table->double('payable_amount',12,2);
            $table->boolean('is_approved_by_inventory')->default(0);
            $table->boolean('is_approved_by_supplychain')->default(0);
            $table->boolean('is_approved_by_hop')->default(0);
            $table->boolean('is_approved_by_ceo')->default(0);
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
        Schema::dropIfExists('cash_flow');
    }
}
