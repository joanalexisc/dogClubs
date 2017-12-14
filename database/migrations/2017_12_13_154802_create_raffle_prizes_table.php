<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRafflePrizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raffle_prizes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('raffle');
            $table->string('name',100);
            $table->unsignedInteger('winner')->nullable();
            $table->timestamps();
        });

        Schema::table('raffle_prizes', function (Blueprint $table) {
            $table->foreign('raffle')->references('id')->on('raffles');
            $table->foreign('winner')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('raffle_prizes');
    }
}
