<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->double('longitude', 14, 8)->nullable();
            $table->double('latitude', 14, 8)->nullable();
            $table->dateTime('timestamp')->nullable();
            $table->double('accuracy', 14, 8)->nullable();
            $table->double('altitude', 14, 8)->nullable();
            $table->double('heading', 14, 8)->nullable();
            $table->double('speed', 14, 8)->nullable();
            $table->double('speed_accuracy', 14, 8)->nullable();
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
        Schema::dropIfExists('positions');
    }
}
