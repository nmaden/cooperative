<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Kvartira extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kvartira', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('etaj_id');
            $table->string('kvartira');
            $table->string('name');
            $table->string('surname');
            $table->string('phone');
            $table->string('amount');
            $table->boolean('ordered')->default(0);
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
        //
    }
}
