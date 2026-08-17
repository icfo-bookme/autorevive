<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsOutsourcedFieldToItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item', function (Blueprint $table) {
            $table->boolean('is_outsourced')->default(0)->after('car_model_id');
            $table->text('thumbnail')->nullable()->change();
            $table->text('details')->nullable()->change();
            $table->string('sales_type')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item', function (Blueprint $table) {
            $table->dropColumn('is_outsourced');
            $table->text('thumbnail')->nullable(false)->change();
            $table->text('details')->nullable(false)->change();
            $table->string('sales_type')->nullable(false)->change();
        });
    }
}
