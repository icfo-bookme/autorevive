<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Item extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {				
         Schema::create('item', function (Blueprint $table) {
            $table->bigIncrements('id');

            // category id
            $table->biginteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('category');

             // sub_category id
            $table->biginteger('sub_category_id')->unsigned();
            $table->foreign('sub_category_id')->references('id')->on('sub_category');

              // brand id
            $table->biginteger('brand_id')->unsigned();
            $table->foreign('brand_id')->references('id')->on('brand');


             // section id
            $table->biginteger('section_id')->nullable()->unsigned();
            $table->foreign('section_id')->references('id')->on('section');

            // item information
            $table->string('name');
            $table->string('barcode',100);
            $table->string('length',50)->nullable();
            $table->string('height',50)->nullable();
            $table->string('width',50)->nullable();
            $table->double('regular_price',12,2)->nullable();
            $table->integer('minimum_order_quantity')->default(1);
            $table->double('sales_price',12,2)->nullable();
            $table->double('cost_price',12,2)->nullable();
            $table->text('thumbnail');
            $table->text('resized_image')->nullable();
            $table->text('details');
            $table->text('specification_details');
            $table->string('sales_type');
            $table->boolean('is_published')->default(0);

            $table->biginteger('car_company_id')->nullable();
            $table->biginteger('car_brand_id')->nullable();
            $table->biginteger('car_model_id')->nullable();

            // others
            $table->string('created_by',50);
            $table->string('updated_by',50);
            $table->boolean('soft_delete')->default(0);
            $table->boolean('has_watermark')->default(0);
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
        Schema::dropIfExists('item');
    }
}
