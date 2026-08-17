<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostInsertAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cost_insert_audits', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('trigger_type',20);
            $table->biginteger('cost_id')->unsigned();
            $table->biginteger('category_id')->unsigned();
            $table->biginteger('subcategory_id')->unsigned();
            $table->double('amount',12,2);
            $table->date('date')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_approved_by_superadmin');
            $table->boolean('is_approved_by_hop');
            $table->boolean('is_approved_by_manager');
            $table->boolean('is_approved_by_accounts');
            $table->boolean('is_approved_by_all');
            $table->string('created_by',50);
            $table->string('updated_by',50);
            $table->boolean('soft_delete');

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
        Schema::dropIfExists('cost_insert_audits');
    }
}
