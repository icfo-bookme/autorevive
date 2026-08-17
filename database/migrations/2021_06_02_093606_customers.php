<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Customers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name',50)->nullable();
            $table->string('last_name',50)->nullable();
            $table->string('email')->nullable();
            $table->string('phone',30)->unique();
            $table->string('address')->nullable();
            $table->string('country',60)->nullable();
            $table->string('district',60)->nullable();
            $table->string('city',60)->nullable();
            $table->string('thana',60)->nullable();
            $table->string('area',60)->nullable();
            $table->string('road_no',20)->nullable();
            $table->string('house_no',20)->nullable();
            $table->string('flat_no',20)->nullable();
            // $table->string('about_us');
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
        Schema::dropIfExists('customers');
    }
}
