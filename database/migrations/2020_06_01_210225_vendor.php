<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Vendor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          //
        Schema::create('vendor', function (Blueprint $table) {
            $table->bigIncrements('id');

            // name and addrss info
            $table->string('name',50);
            $table->text('address');

            // contact info
            $table->string('contact_person',50);
            $table->string('phone_number',30);

            // others
            $table->string('created_by',50);
            $table->string('updated_by',50);
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('vendor');
    }
}
