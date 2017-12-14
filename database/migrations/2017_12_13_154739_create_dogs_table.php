<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dogs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 150);
            $table->char('sex', 1);
            $table->date('birthday');
            $table->unsignedInteger('purity');
            $table->string('breeder', 150)->nullable();
            $table->string('mother', 150)->nullable();
            $table->string('father', 150)->nullable();
            $table->boolean('isAlive');
            $table->timestamps();


            $table->index('name');
            $table->index('sex');
            $table->index('breeder');
            $table->index('mother');
            $table->index('father');


        });

        Schema::table('dogs', function (Blueprint $table) {
            $table->foreign('purity')->references('id')->on('purities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dogs');
    }
}
