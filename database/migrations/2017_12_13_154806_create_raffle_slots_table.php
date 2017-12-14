<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRaffleSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raffle_slots', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('raffle');
            $table->unsignedInteger('number');
            $table->unsignedInteger('user')->nullablle();
            $table->unsignedInteger('payment_status')->nullable();
            $table->timestamps();
        });

        Schema::table('raffle_slots', function (Blueprint $table) {
            $table->foreign('raffle')->references('id')->on('raffles');
            $table->foreign('user')->references('id')->on('users');
            $table->foreign('payment_status')->references('id')->on('payment_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('raffle_slots');
    }
}
