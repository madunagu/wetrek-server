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
            $table->string('formatted_address');
            $table->string('place_id')->nullable();
            $table->text('types')->nullable();
            $table->text('plus_code')->nullable();
            $table->text('geometry')->nullable();
            $table->text('address_components')->nullable();
            $table->integer('user_id');
           
            $table->double('lng', 14, 8)->nullable();
            $table->double('lat', 14, 8)->nullable();

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
