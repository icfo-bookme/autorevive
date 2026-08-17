<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeleteFieldToAdvancePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advance_payments', function (Blueprint $table) {
            $table->boolean('soft_delete')->default(0)->after('payment_collected_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('advance_payments', function (Blueprint $table) {
            $table->dropColumn('soft_delete');
        });
    }
}
