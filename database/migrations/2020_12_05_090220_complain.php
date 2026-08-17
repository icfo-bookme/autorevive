<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Complain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complains', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('delivery_man_id');
            $table->string('complain');
            $table->string('complain_detail');
            $table->string('created_by',50)->nullable();
            $table->string('updated_by',50)->nullable();
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
        Schema::dropIfExists('complains');
    }
}
