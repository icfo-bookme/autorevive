<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PermissionRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            // user id
            $table->biginteger('user_id')->unsigned();   
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('previous_url');
            $table->string('current_url');
            $table->boolean('permission')->default(0);
            $table->string('requested_by',50);
            $table->string('approved_by',50)->nullable();
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_requests');
    }
}
