<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyCreatedByAndAddUpdatedByToBookingsTable extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('created_by');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->string('created_by', 50)->nullable()->after('soft_delete');
            $table->string('updated_by', 50)->nullable()->after('created_by');
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['created_by', 'updated_by']);
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->string('created_by', 50)->nullable();
        });
    }
}
