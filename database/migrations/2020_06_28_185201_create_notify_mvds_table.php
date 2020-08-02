<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifyMvdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notify_mvds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('transaction_id')->unsigned();
            $table->string('first_name'); // Имя
            $table->string('last_name'); // Фамилия
            $table->string('middle_name')->nullable(); // Отчество
            $table->date('birthday');
            $table->enum('gender', ['male', 'female']);
            // $table->boolean('residency');
            $table->string('purpose_visit')->nullable(); // Цель визита
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->dateTime('check_in');
            $table->dateTime('check_out');
            $table->string('citizenship'); // Гражданство
            $table->string('document_type'); // TODO: check this type
            $table->string('document_series')->nullable();
            $table->string('document_number');
            $table->date('document_date_start');
            $table->date('document_date_end');
            $table->string('hotel_user_first_name')->nullable(); // Имя владельца квартиры
            $table->string('hotel_user_last_name')->nullable(); // Фамилия владельца квартиры
            $table->string('hotel_user_middle_name')->nullable(); // Отчество владельца квартиры
            $table->string('hotel_document_number')->nullable();
            $table->string('hotel_bin');
            $table->string('hotel_name'); // Название место размещения
            $table->string('hotel_region');
            $table->string('hotel_address');
            $table->string('hotel_house');
            $table->string('hotel_apartment')->nullable(); // Квартира
            $table->enum('status', [
                'canceled', 'completed', 'created', 'denied', 'expired', 'failed', 'pending'
            ])->default('created');
            $table->timestamps();
        });

        Schema::table('notify_mvds', function (Blueprint $table) {
            $table->foreign('transaction_id')->references('id')->on('transactions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notify_mvds', function (Blueprint $table) {
            $table->dropForeign(['transaction_id']);
        });

        Schema::dropIfExists('notify_mvds');
    }
}
