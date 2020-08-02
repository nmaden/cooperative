<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('hotel_id');
            $table->integer('kato_id');
            $table->integer('target_id');
            $table->string('surname');
            $table->string('name')->nullable();
            $table->string('patronymic')->nullable();
            $table->date('date_birth');
            $table->integer('gender_id');
            $table->integer('doctype_id');
            $table->string('series_documents')->nullable();
            $table->string('document_number');
            $table->date('valid_until')->comment('Действителен до');
            $table->date('date_issue')->comment('Дата выдачи документа');
            $table->date('start_check_date')->comment('Дата начала прибывания');
            $table->date('end_check_date')->comment('Дата окончания прибывания');
            $table->string('email',512)->nullable();
            $table->string('phone',512)->nullable();
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
        Schema::dropIfExists('clients');
    }
}
