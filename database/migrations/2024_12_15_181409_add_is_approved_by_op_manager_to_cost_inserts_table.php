<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsApprovedByOpManagerToCostInsertsTable extends Migration
{
    public function up()
    {
        Schema::table('cost_inserts', function (Blueprint $table) {
            // Add the new column after the `is_approved_by_accounts` column
            $table->boolean('is_approved_by_opManager')->default(false)->after('is_approved_by_accounts');
        });
    }

    public function down()
    {
        Schema::table('cost_inserts', function (Blueprint $table) {
            $table->dropColumn('is_approved_by_opManager');
        });
    }
}
