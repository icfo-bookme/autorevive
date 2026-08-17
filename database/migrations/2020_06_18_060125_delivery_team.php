<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeliveryTeam extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('delivery_team', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',50);
            $table->string('contact_number',50);
            $table->string('alt_contact_number',50)->nullable();
            $table->text('address');
            $table->string('NID')->nullable();
            $table->bigInteger('role_id');
            $table->string('created_by',50);
            $table->string('updated_by',50);
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
        Schema::dropIfExists('delivery_team');
    }
}
