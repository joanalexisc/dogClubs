<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('concept');
            // $table->unsignedInteger('voucher_picture');
            $table->double('amount', 8, 2);
            $table->unsignedInteger('status');
            $table->text('comments', 300)->nullable();
            $table->text('transaction_ids');	
            $table->timestamps();
        });

        Schema::table('payments', function (Blueprint $table) {
            // $table->foreign('voucher_picture')->references('id')->on('pictures');
            $table->foreign('concept')->references('id')->on('payment_concepts');
            $table->foreign('status')->references('id')->on('payment_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
