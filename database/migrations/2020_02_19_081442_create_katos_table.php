<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('katos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('egov_id');
            $table->integer('egov_parent_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('level');
            $table->integer('area_type');
            $table->string('name_kaz',512);
            $table->string('name_rus',512);
            $table->bigInteger('code');
            $table->boolean('is_marked_to_delete');
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
        Schema::dropIfExists('katos');
    }
}
