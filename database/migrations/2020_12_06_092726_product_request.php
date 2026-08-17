<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_name',50);
            $table->string('user_phone',30);
            $table->string('user_email')->nullable();
            $table->string('product_detail');
            $table->string('product_image')->nullable();
            $table->boolean('is_approved');
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
        Schema::dropIfExists('product_requests');
    }
}
