<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDuplicateFlagFieldToStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock', function (Blueprint $table) {
            $table->boolean('duplicate_flag')->default(0)->after('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock', function (Blueprint $table) {
            $table->dropColumn('duplicate_flag');
        });
    }
}
