<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseDraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_drafts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('purchase_id')->unsigned()->nullable();
            $table->foreign('purchase_id')->references('id')->on('purchase');
            $table->double('amount',12,2);
            $table->string('note')->nullable();
            $table->boolean('is_purchased')->default(0);
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
        Schema::dropIfExists('purchase_drafts');
    }
}
