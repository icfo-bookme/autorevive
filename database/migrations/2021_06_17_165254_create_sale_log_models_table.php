<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleLogModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_logs', function (Blueprint $table) {
            $table->bigIncrements('id');

             // sale id
             $table->biginteger('sales_id')->unsigned();
             $table->foreign('sales_id')->references('id')->on('sales');

            // order id
            $table->biginteger('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders');

            // customer info
            $table->string('first_name',50);
            $table->string('last_name',50)->nullable();
            $table->string('phone_number',30);
            $table->string('email')->nullable();
            $table->string('city',60)->nullable();
            $table->string('company_name',60)->nullable();
            $table->string('address_1',60)->nullable();
            $table->string('address_2',60)->nullable();
            $table->string('order_notes')->nullable();

            // others info
            $table->integer('status')->default(0)->comment('payment-status of website orders');
            $table->double('price',12,2)->nullable();
            $table->double('cost_price',12,2)->nullable();

            $table->integer('is_shipment_charge_applied')->nullable();
            $table->double('discount_amount',12,2)->default(0);
            $table->double('advance_payment',12,2)->default(0)->comment('At booking');
            $table->double('collected_payment',12,2)->default(0)->comment('actual collected_payment=(collected_payment)+latest(due_paid) from sales_due_payment_log table');
            $table->boolean('is_due_paid')->default(1);
            $table->integer('payment_due')->default(0)->comment('actual payment_due=(payment_due)-latest(due_paid) from sales_due_payment_log table');

            $table->string('sales_by',50)->nullable();
            $table->string('sales_created_at',50)->nullable();
            $table->string('created_by',50)->nullable();
            $table->string('updated_by',50)->nullable();
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
        Schema::dropIfExists('sale_logs');
    }
}
