<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompletedAtToSalesNewLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_new_logs', function (Blueprint $table) {
            $table->timestamp('completed_at')->after('invoice_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_new_logs', function (Blueprint $table) {
            $table->dropColumn('completed_at');
        });
    }
}
