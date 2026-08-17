<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CarModel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_model', function (Blueprint $table) {

            $table->bigIncrements('id');

            // item information
            $table->string('car_model',50);
            $table->biginteger('company_id')->unsigned();
            $table->biginteger('brand_id')->unsigned();

            $table->foreign('company_id')->references('id')->on('car');
	        $table->foreign('brand_id')->references('id')->on('car_brands');

            // others
            $table->string('created_by',50);
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
        Schema::dropIfExists('car_model');
    }
}
