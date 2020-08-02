<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('room_type_id')->unsigned()->default(1);
            $table->foreign('room_type_id')->references('id')->on('hotel_room_types');   
            $table->date('date')->nullable();
            $table->integer('price')->nullable();
            $table->boolean('price_per_person')->nullable();
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
        Schema::dropIfExists('daily_prices');
    }
}
