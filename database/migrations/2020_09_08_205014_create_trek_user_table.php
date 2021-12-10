<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrekUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trek_user', function (Blueprint $table) {
            $table->id();
            $table->integer('trek_id');
            $table->integer('user_id');
            $table->string('status')->default('registered'); //registered,started, moving, unavailable
            $table->dateTime('moved_at')->nullable();
            $table->dateTime('ended_at')->nullable();
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
        Schema::dropIfExists('trek_user');
    }
}
