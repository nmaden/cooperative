<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('min_stat_id')->nullable();
            $table->string('name');
            $table->string('description');
            $table->integer('region_id');
            $table->integer('city_id');
            $table->integer('area_id')->nullable();
            $table->string('street',512);
            $table->string('house',512);
            $table->string('BIN')->comment('БИН места размещения');
            $table->string('PMS')->comment('Используемая система PMS');
            $table->integer('number_rooms')->comment('Количество номеров');
            $table->integer('number_beds')->comment('Количество койко-мест');
            $table->string('entity')->comment('Юридическое лицо');
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
        Schema::dropIfExists('hotels');
    }
}
