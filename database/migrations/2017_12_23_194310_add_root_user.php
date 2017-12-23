<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;



class AddRootUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('users', function (Blueprint $table) {
        //     //
        // });
            /*
            $table->string('personal_id',11);
            $table->string('mobile',10);
            $table->string('home',10)->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->date('birthday');
            // $table->unsignedInteger('profile_pic');
            $table->string('names',100);
            $table->string('last_names',100);
            $table->char('sex',1);
            $table->string('address',500);
            // $table->unsignedInteger('role');
            $table->unsignedInteger('status');
            $table->rememberToken();
            $table->timestamps();

            $table->index('names');
            $table->index('last_names');
            $table->index('personal_id');
            $table->index('mobile');
            */

        $pass = \Hash::make('root');

        DB::table('users')->insert([
            [
            'id' => '0',
            'personal_id' => '00000000000', 
            'mobile' => '0000000000',
            'password' => $pass,
            'email' => 'neo@husky.com',
            'birthday' => Carbon\Carbon::now(),
            'Names' => 'Neo',
            'last_names' => 'The Choosen One',
            'sex' => 'M',
            'address' => 'The Matrix',
            'status' => '3',
            'is_verified' => '1'
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('users', function (Blueprint $table) {
        //     //
        // });
    }
}
