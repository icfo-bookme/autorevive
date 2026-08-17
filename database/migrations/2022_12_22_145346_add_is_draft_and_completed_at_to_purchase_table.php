<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsDraftAndCompletedAtToPurchaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase', function (Blueprint $table) {
            $table->timestamp('completed_at')->after('remarks')->nullable();
            $table->boolean('is_draft')->default(0)->after('remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase', function (Blueprint $table) {
            $table->dropColumn('is_draft');
            $table->dropColumn('completed_at');
            
        });
    }
}
