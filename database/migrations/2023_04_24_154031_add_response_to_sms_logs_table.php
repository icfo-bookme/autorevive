<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddResponseToSmsLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sms_logs', function (Blueprint $table) {
            $table->string('status')->after('message')->nullable();
            $table->string('status_code')->after('status')->nullable();
            $table->string('error_message')->after('status_code')->nullable();
            $table->json('smsinfo')->after('error_message')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sms_logs', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('status_code');
            $table->dropColumn('error_message');
            $table->dropColumn('smsinfo');
        });
    }
}
