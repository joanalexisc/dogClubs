<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemPicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_pictures', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item_id');
            $table->unsignedInteger('picture_id');
            $table->timestamps();

            $table->index('item_id');
        });

        Schema::table('item_pictures', function (Blueprint $table) {
            $table->foreign('picture_id')->references('id')->on('pictures');
            // $table->foreign('category')->references('id')->on('notification_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_pictures');
    }
}
