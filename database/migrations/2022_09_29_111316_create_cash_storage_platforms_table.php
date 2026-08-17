<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashStoragePlatformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_storage_platforms', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->double('amount',12,2)->default(0);
            $table->string('created_by',50)->nullable();
            $table->string('updated_by',50)->nullable();            
            $table->boolean('soft_delete')->default(0);

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
        Schema::dropIfExists('cash_storage_platforms');
    }
}
