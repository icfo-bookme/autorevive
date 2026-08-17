<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Highlights extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('highlights', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('type_id')->unsigned();
            $table->string('type',20);
            $table->string('summary')->nullable();
            $table->string('created_by',50);
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
        Schema::dropIfExists('highlights');
    }

}
