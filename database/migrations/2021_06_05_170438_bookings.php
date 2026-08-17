<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Bookings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            // customer info
            $table->string('first_name',50);
            $table->string('last_name',50);
            $table->string('phone_number',30);
            $table->string('email')->nullable();
            $table->string('country',60)->nullable();
            $table->string('district',60)->nullable();
            $table->string('city',60)->nullable();
            $table->string('thana',60)->nullable();
            $table->string('area',60)->nullable();
            $table->string('road_no',20)->nullable();
            $table->string('house_no',20)->nullable();
            $table->string('flat_no',20)->nullable();
            $table->string('car_no',20)->nullable();
            $table->string('booking_notes')->nullable();
            $table->string('customer_notes')->nullable();

            $table->double('advance_payment',12,2);
            $table->double('discount_amount',12,2)->default(0);
            $table->double('shipping_amount',12,2)->default(0);

            // others info
            $table->integer('status')->default(0);
            $table->string('created_by',50)->nullable();
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
        Schema::dropIfExists('bookings');
    }
}
