<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('when');
            $table->string('title',100);
            $table->string('descripcion',500);
            $table->unsignedInteger('payment_type');
            $table->decimal('amount', 8, 2);
            $table->timestamps();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->foreign('payment_type')->references('id')->on('payment_types');
            // $table->foreign('concept')->references('id')->on('payment_concepts');
            // $table->foreign('status')->references('id')->on('payment_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
