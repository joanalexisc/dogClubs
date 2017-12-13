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
            $table->string('name', 50);
            $table->char('sex', 1);
            $table->date('birthday');
            $table->unsignedInteger('purity');
            $table->string('breeder', 150);
            $table->string('mother', 150);
            $table->string('father', 150);
            $table->boolean('isAlive');
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
        Schema::dropIfExists('dogs');
    }
}
