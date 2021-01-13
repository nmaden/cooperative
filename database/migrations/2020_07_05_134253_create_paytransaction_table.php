<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaytransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paytransaction', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('client_id');
            $table->integer('amount');
            $table->string('type_of_transaction');
            $table->string('street_of_bank');
            $table->date('date_of_transaction');
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
        Schema::dropIfExists('paytransaction');
    }
}
