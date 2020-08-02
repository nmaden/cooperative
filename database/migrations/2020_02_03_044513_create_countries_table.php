<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('vmp_id');
            $table->integer('code');
            $table->integer('vmpVisible');
            $table->string('name_kaz',512);
            $table->string('name_rus',512);
            $table->string('name_eng',512);
            $table->integer('max_period_registration');
            $table->boolean('visa_required');
            $table->integer('allowed_days_without_registration');
            $table->string('country_code');
            $table->string('alpha3')->nullable();
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
        Schema::dropIfExists('countries');
    }
}
