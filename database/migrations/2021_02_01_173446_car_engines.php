<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CarEngines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_engines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('car_engine',50);

            $table->unsignedBigInteger('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('car');
	        
            $table->unsignedBigInteger('brand_id')->unsigned();
            $table->foreign('brand_id')->references('id')->on('car_brands');

            $table->unsignedBigInteger('model_id')->unsigned();
            $table->foreign('model_id')->references('id')->on('car_model');

            $table->string('created_by',50);
            $table->string('updated_by',50);
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
        Schema::dropIfExists('car_engines');
    }
}
