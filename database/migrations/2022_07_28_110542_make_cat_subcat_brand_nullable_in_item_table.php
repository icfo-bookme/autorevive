<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeCatSubcatBrandNullableInItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('item', function (Blueprint $table) {
            //For category id
            $table->dropForeign('item_category_id_foreign');
            $table->unsignedBigInteger('category_id')->nullable()->change();
            $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');

            //For subcategory id
            $table->dropForeign('item_sub_category_id_foreign');
            $table->unsignedBigInteger('sub_category_id')->nullable()->change();
            $table->foreign('sub_category_id')->references('id')->on('sub_category')->onDelete('cascade');

            //For brand id
            $table->dropForeign('item_brand_id_foreign');
            $table->unsignedBigInteger('brand_id')->nullable()->change();
            $table->foreign('brand_id')->references('id')->on('brand')->onDelete('cascade');

        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('item', function (Blueprint $table) {
            //For category id
            $table->dropForeign('item_category_id_foreign');
            $table->unsignedBigInteger('category_id')->nullable(false)->change();
            $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');

            //For subcategory id
            $table->dropForeign('item_sub_category_id_foreign');
            $table->unsignedBigInteger('sub_category_id')->nullable(false)->change();
            $table->foreign('sub_category_id')->references('id')->on('sub_category')->onDelete('cascade');

            //For brand id
            $table->dropForeign('item_brand_id_foreign');
            $table->unsignedBigInteger('brand_id')->nullable(false)->change();
            $table->foreign('brand_id')->references('id')->on('brand')->onDelete('cascade');
        });
        Schema::enableForeignKeyConstraints();
    }
}
