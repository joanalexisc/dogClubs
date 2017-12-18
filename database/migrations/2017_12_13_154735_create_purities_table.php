<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePuritiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description', 100)->unique();
            $table->timestamps();
        });

        DB::table('purities')->insert([
            ['description' => 'Sin Certificacion'],  
            ['description' => '1era Inspeccion'],  
            ['description' => '2da Inspeccion'],  
            ['description' => '3ra Inspeccion'],  
            ['description' => 'Pedigree']  
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purities');
    }
}
