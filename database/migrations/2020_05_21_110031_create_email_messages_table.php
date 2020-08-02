<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('hotel_id')->unsigned();
            $table->enum('color', ['#654BD8', '#FFCE03', '#D84B4B', '#03FF59', '#A5A5A5', '#FF5E03', '#2F69FF', '#873D1E']);
            $table->string('appeal');
            $table->string('welcome_text');
            $table->string('farewell_text'); //------->>> Прощальный текст
            $table->string('instant_text');  //------->>> мгновенный текст
            $table->string('subject_text');  //------->>> текст темы
            $table->boolean('status_booking');
            $table->boolean('status_pay');
            $table->boolean('status_cancel');
            $table->boolean('status_weather')->nullable();
            $table->string('signature_text');
            $table->timestamps();
        });

        Schema::table('email_messages', function(Blueprint $table) {
            $table->foreign('hotel_id')->references('id')->on('hotels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_messages');
    
    }
}
