<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFundInsertAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_insert_audits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('trigger_type',20);
            $table->biginteger('fund_id')->unsigned();
            $table->biginteger('category_id')->unsigned();
            $table->biginteger('subcategory_id')->unsigned()->nullable();
            $table->double('amount',12,2);
            $table->date('date')->nullable();
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
        Schema::dropIfExists('fund_insert_audits');
    }
}
