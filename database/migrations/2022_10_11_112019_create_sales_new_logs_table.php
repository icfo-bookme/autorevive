<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesNewLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_new_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            // sale id
            $table->biginteger('sales_id')->unsigned();
            $table->foreign('sales_id')->references('id')->on('sales');
            // order id
            $table->biginteger('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders');

            $table->string('first_name',50);
            $table->string('last_name',50)->nullable();
            $table->string('phone_number',30);
            $table->string('email')->nullable();
            $table->string('company_name',60)->nullable();
            $table->string('address_1',60)->nullable();
            $table->string('remarks',60)->nullable();
            $table->string('country',60)->nullable();
            $table->string('district',60)->nullable();
            $table->string('city',60)->nullable();
            $table->string('thana',60)->nullable();
            $table->string('area',60)->nullable();
            $table->string('road_no',20)->nullable();
            $table->string('house_no',20)->nullable();
            $table->string('flat_no',20)->nullable();
            $table->string('car_no',20)->nullable();
            $table->string('order_notes')->nullable();
            $table->tinyInteger('status')->comment('payment-status of website orders');
            $table->double('price',12,2)->nullable();
            $table->double('cost_price',12,2)->nullable();
            $table->integer('is_shipment_charge_applied')->nullable();
            $table->double('discount_amount',12,2);
            $table->double('advance_payment',12,2)->comment('At booking');
            $table->double('collected_payment',12,2)->comment('actual collected_payment=(collected_payment)+latest(due_paid) from sales_due_payment_log table');
            $table->boolean('is_due_paid')->default(1);
            $table->double('payment_due')->comment('actual payment_due=(payment_due)-latest(due_paid) from sales_due_payment_log table');
            $table->double('total_price')->default(0)->comment('subtotal');
            $table->double('paid_amount')->default(0)->comment('due paid');
            $table->tinyInteger('payment_method');
            $table->tinyInteger('is_cancelled');
            $table->string('cancelled_by',50)->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->date('invoice_date')->nullable();
            $table->string('sales_by',50);
            $table->string('sales_updated_by',50);
            $table->string('created_by',50);
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
        Schema::dropIfExists('sales_new_logs');
    }
}
