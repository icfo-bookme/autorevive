<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashInsertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_inserts', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->double('cash_amount',12,2);
            $table->string('description');
            $table->date('date');
            $table->boolean('soft_delete')->default(0);
            $table->string('created_by',50)->nullable();
            $table->string('updated_by',50)->nullable();

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
        Schema::dropIfExists('cash_inserts');
    }
}
