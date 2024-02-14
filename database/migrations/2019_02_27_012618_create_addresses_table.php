<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('place_id')->nullable();
            $table->string('reference')->nullable();
            $table->text('types')->nullable();
            $table->text('geometry')->nullable();
            $table->integer('user_id');
           
            $table->double('latitude', 14, 8)->nullable();
            $table->double('longitude', 14, 8)->nullable();

            $table->softDeletes();
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
        Schema::dropIfExists('addresses');
    }
}
