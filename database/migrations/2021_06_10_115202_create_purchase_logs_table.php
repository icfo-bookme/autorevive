<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
             // purchase id
             $table->bigInteger('purchase_id')->unsigned();
             $table->foreign('purchase_id')->references('id')->on('purchase');
              // vendor id
              $table->bigInteger('vendor_id')->unsigned();
              $table->foreign('vendor_id')->references('id')->on('vendor');
              
              $table->string('invoice_number');
              $table->date('purchase_date');
  
              $table->double('total_amount',12,2);
              $table->double('paid_amount',12,2);
              $table->double('due_amount',12,2);
  
              $table->text('challan_img')->nullable();
  
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
        Schema::dropIfExists('purchase_logs');
    }
}
