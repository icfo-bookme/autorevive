<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFundInsertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_inserts', function (Blueprint $table) {
            $table->bigIncrements('id');
            // Fund category id
            $table->biginteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('fund_categories');
            // Fund subcategory id
            $table->biginteger('subcategory_id')->unsigned()->nullable();
            $table->foreign('subcategory_id')->references('id')->on('fund_sub_categories');
            $table->double('amount',12,2);
            $table->text('description')->nullable();
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
        Schema::dropIfExists('fund_inserts');
    }
}
