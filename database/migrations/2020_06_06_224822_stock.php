<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Stock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('stock', function (Blueprint $table) {
            $table->bigIncrements('id');

             // item info
            $table->biginteger('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('item');  


            $table->string('code',100);
            $table->integer('quantity');
            $table->string('uom',50);



            // others
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
        Schema::dropIfExists('stock');
    }
}
