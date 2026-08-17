<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('contact_table', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',50);
            $table->string('email');
            $table->string('contact_number',30);
            $table->text('message');
            $table->string('type',30)->nullable();
            $table->boolean('is_replied')->default(0);
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
        Schema::dropIfExists('contact_table');
    }
}
