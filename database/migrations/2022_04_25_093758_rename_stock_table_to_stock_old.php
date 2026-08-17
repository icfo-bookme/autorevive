<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameStockTableToStockOld extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_old', function (Blueprint $table) {
            Schema::rename('stock','stock_old');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_old', function (Blueprint $table) {
            Schema::rename('stock_old','stock');
        });
    }
}
