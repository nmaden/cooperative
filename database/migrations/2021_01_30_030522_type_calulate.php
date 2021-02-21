<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TypeCalulate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_calculate', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('calculation_id');
            $table->string('type')->nullable();
            $table->string('comment')->nullable();
            
            $table->string('type_calculate')->nullable();
            
            $table->integer('price')->nullable();
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
