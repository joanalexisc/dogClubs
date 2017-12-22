<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 30)->unique();
            $table->string('description', 100);
            $table->timestamps();
        });

        DB::table('user_statuses')->insert([
            ['code' => 'REG', 'description' => 'Registrado, pendiente envio de pago'],
            ['code' => 'PAP', 'description' => 'Comprobante de pago enviado'],
            ['code' => 'APPR', 'description' => 'Aprovado'],
            ['code' => 'DIS', 'description' => 'Desactivar'],
            ['code' => 'EXP', 'description' => 'Expulsado ']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_statuses');
    }
}
