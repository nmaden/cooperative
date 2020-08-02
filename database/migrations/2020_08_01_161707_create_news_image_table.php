<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('news_image', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('news_id')->unsigned();
            $table->string('image');
            $table->string('thumbnail');
            $table->timestamps();
        });

        Schema::table('news_image', function (Blueprint $table) {
            $table->foreign('news_id')->references('id')->on('news');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('news_image', function (Blueprint $table) {
            $table->dropForeign(['news_id']);
        });

        Schema::dropIfExists('news_image');
    }
}
