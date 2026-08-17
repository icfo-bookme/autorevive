<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashWithdrawTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_withdraw', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->date('date');
            $table->text('description');
            $table->double('amount',12,2);
            $table->integer('withdraw_by');
            $table->string('inserted_by',50);

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
        Schema::dropIfExists('cash_withdraw');
    }
}
