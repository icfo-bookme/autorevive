<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name',60);
            $table->string('last_name',60);
            $table->string('email')->unique();
            $table->string('phone',30)->nullable();
            $table->string('address');

            $table->string('country',60)->nullable();
            $table->string('district',60)->nullable();
            $table->string('city',60)->nullable();
            $table->string('thana',60)->nullable();
            $table->string('area',60)->nullable();
            $table->string('road_no',20)->nullable();
            $table->string('house_no',20)->nullable();
            $table->string('flat_no',20)->nullable();
            $table->string('NID',100)->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }

}
