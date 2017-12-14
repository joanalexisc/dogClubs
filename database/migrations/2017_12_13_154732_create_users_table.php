<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('club');
            $table->string('personal_id',11);
            $table->string('mobile',10);
            $table->string('home',10)->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->date('birthday');
            $table->unsignedInteger('profile_pic');
            $table->string('names',100);
            $table->string('last_names',100);
            $table->char('sex',1);
            $table->unsignedInteger('role');
            $table->unsignedInteger('status');
            $table->rememberToken();
            $table->timestamps();

            $table->index('names');
            $table->index('last_names');
            $table->index('personal_id');
            $table->index('mobile');
            

        });

        Schema::table('users', function (Blueprint $table) {
            // $table->foreign('user')->references('id')->on('users');
            $table->foreign('club')->references('id')->on('clubs');
            $table->foreign('profile_pic')->references('id')->on('pictures');
            $table->foreign('role')->references('id')->on('roles');
            $table->foreign('status')->references('id')->on('user_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
