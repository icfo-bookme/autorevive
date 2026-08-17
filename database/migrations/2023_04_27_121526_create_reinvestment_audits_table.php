<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReinvestmentAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reinvestment_audits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('trigger_type',20);
            $table->biginteger('reinvestments_id')->unsigned();
            $table->double('amount',12,2);
            $table->date('date')->nullable();
            $table->text('description')->nullable();
            $table->string('created_by',50);
            $table->string('updated_by',50);
            $table->boolean('soft_delete');

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
        Schema::dropIfExists('reinvestment_audits');
    }
}
