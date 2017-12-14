<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventParticipationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_participations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('event');
            $table->unsignedInteger('user');
            $table->unsignedInteger('payment_status');
            $table->text('comments',500)->nullable();
            $table->unsignedInteger('event_participation_status');
            $table->timestamps();
        });

        Schema::table('event_participations', function (Blueprint $table) {
            $table->foreign('event')->references('id')->on('events');
            $table->foreign('user')->references('id')->on('users');
            $table->foreign('payment_status')->references('id')->on('payment_statuses');
            $table->foreign('event_participation_status')->references('id')->on('event_participation_statuses');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_participations');
    }
}
