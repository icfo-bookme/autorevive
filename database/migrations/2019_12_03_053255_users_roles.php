<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('users_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->biginteger('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles');
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
        Schema::dropIfExists('users_roles');
    }
}
