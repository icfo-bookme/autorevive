<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostEditReasonsTable extends Migration
{
    public function up()
    {
        Schema::create('cost_edit_reasons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cost_insert_id');
            $table->unsignedBigInteger('category_id')->nullable();  
            $table->unsignedBigInteger('subcategory_id')->nullable(); 
            $table->double('amount', 12, 2)->nullable();
            $table->double('prev_amount', 12, 2)->nullable();
            $table->date('date')->nullable();
            $table->text('description')->nullable();
            $table->text('reason');
            $table->string('created_by', 50);
            $table->boolean('soft_delete')->default(0);
            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('cost_insert_id')->references('id')->on('cost_inserts')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('cost_categories')->onDelete('set null');
            $table->foreign('subcategory_id')->references('id')->on('cost_sub_categories')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cost_edit_reasons');
    }
}
