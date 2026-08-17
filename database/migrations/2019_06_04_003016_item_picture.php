<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ItemPicture extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_picture', function (Blueprint $table) {
            $table->bigIncrements('id');

            // item id
            $table->biginteger('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('item');

            // picture path
            $table->text('image_path');
            
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
        Schema::dropIfExists('item_picture');
    }
}
