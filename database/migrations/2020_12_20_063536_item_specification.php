<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ItemSpecification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_specification', function (Blueprint $table) {
            $table->bigIncrements('id');

            // item id
            $table->biginteger('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('item');

            // item_specification information
            $table->string('name')->nullable();
            $table->string('details')->nullable();

            // others
            $table->string('created_by',50);
            $table->string('updated_by',50);
            $table->boolean('soft_delete')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('item_specification');
    }
}
