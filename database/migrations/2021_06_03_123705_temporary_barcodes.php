<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TemporaryBarcodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temporary_barcodes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->biginteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('category');
            $table->string('barcode',100);
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('temporary_barcodes');
    }
}
