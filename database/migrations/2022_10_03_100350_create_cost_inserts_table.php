<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostInsertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cost_inserts', function (Blueprint $table) {
            $table->bigIncrements('id');
            // Cost category id
            $table->biginteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('cost_categories');
            // Cost category id
            $table->biginteger('subcategory_id')->unsigned();
            $table->foreign('subcategory_id')->references('id')->on('cost_sub_categories');
            $table->double('amount',12,2);
            $table->text('description')->nullable();
            $table->boolean('is_approved_by_superadmin')->default(0);
            $table->boolean('is_approved_by_hop')->default(0);
            $table->boolean('is_approved_by_manager')->default(0);
            $table->boolean('is_approved_by_accounts')->default(0);
            $table->boolean('is_approved_by_all')->default(0);
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
        Schema::dropIfExists('cost_inserts');
    }
}
