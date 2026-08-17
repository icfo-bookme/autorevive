<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RolesDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('roles_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles');
            $table->biginteger('module_id')->unsigned();
            $table->foreign('module_id')->references('id')->on('modules');
            $table->string('created_by',50);
            $table->boolean('soft_delete')->default(0);
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
        Schema::dropIfExists('roles_details');
    }
}
