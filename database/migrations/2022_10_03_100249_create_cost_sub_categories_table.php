<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cost_sub_categories', function (Blueprint $table) {
            $table->bigIncrements('id');

            // category id
            $table->biginteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('cost_categories');
            // name of sub-category
            $table->string('name',50);
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
        Schema::dropIfExists('cost_sub_categories');
    }
}
