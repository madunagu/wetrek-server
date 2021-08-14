<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('start_address_id');
            $table->integer('end_address_id');
            $table->string('repeat')->nullable();
            $table->text('direction')->nullable();
            $table->dateTime('starting_at')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('description')->nullable();
            $table->integer('user_id');
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
        Schema::dropIfExists('treks');
    }
}
