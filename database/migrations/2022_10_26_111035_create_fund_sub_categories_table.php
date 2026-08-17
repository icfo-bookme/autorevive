<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFundSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_sub_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('fund_categories');
            
            $table->string('name',50);
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
        Schema::dropIfExists('fund_sub_categories');
    }
}
