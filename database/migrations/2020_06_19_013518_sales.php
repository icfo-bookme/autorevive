<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Sales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');

            // order id
            $table->biginteger('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders');

            // customer info
            $table->string('first_name',50);
            $table->string('last_name',50);
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
            $table->double('cost_price',12,2)->nullable()->comment('value updates after purchase');

            $table->integer('is_shipment_charge_applied')->nullable();
            $table->double('discount_amount',12,2)->default(0);
            $table->double('advance_payment',12,2)->default(0)->comment('At booking');
            $table->double('collected_payment',12,2)->default(0)->comment('At sale + if returned,then added the total due paid');
            $table->boolean('is_due_paid')->default(1);
            $table->double('payment_due',12,2)->default(0);
            $table->integer('is_cancelled')->default(0);
            $table->string('cancelled_by',50)->nullable();
            $table->timestamp('cancelled_at')->nullable();

            $table->string('sales_by',50)->nullable();
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
        Schema::dropIfExists('sales');
    }
}
