<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Orders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name',50);
            $table->string('last_name',50)->nullable();
            $table->string('phone_number',30);
            $table->string('email')->nullable();
            $table->string('company_name')->nullable();
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('country',60)->nullable();
            $table->string('district',60)->nullable();
            $table->string('city',60)->nullable();
            $table->string('thana',60)->nullable();
            $table->string('area',60)->nullable();
            $table->string('road_no',20)->nullable();
            $table->string('house_no',20)->nullable();
            $table->string('flat_no',20)->nullable();
            $table->string('car_no',20)->nullable();
            $table->string('order_code');
            $table->string('order_notes',100)->nullable();
            $table->string('customer_notes',100)->nullable();
            $table->string('delivery_type',20)->nullable();

            $table->boolean('is_approve')->default(0);
            $table->timestamp('approved_at')->nullable();
            $table->string('approved_by',50)->nullable();
            $table->biginteger('team_leader_id')->nullable();
            $table->integer('shipment_assigned')->default(0);
            $table->timestamp('shipment_assigned_at')->nullable();
            $table->string('shipment_assigned_by',50)->nullable();
            $table->integer('is_shipment')->default(0);
            $table->timestamp('shipment_completed_at')->nullable();
            $table->integer('status')->default(0);
            $table->integer('is_payment')->default(0);
            $table->timestamp('payment_collected_at')->nullable();
            $table->integer('is_rejected')->default(0);
            $table->string('rejected_by',50)->nullable();
            $table->timestamp('rejected_at')->nullable();

            $table->integer('is_shipment_charge_applied')->nullable();
            $table->double('discount_amount',12,2)->default(0);
            $table->double('advance_payment',12,2)->default(0);
            $table->double('collected_payment',12,2)->default(0);
            $table->integer('is_due_paid')->default(1);
            $table->integer('payment_due')->default(0);

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
        Schema::dropIfExists('orders');
    }
}
