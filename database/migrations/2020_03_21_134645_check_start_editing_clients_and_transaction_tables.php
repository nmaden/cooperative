<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CheckStartEditingClientsAndTransactionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('start_check_date');
            $table->dropColumn('end_check_date');

        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->date('start_check_date')->comment('Дата начала прибывания');
            $table->date('end_check_date')->comment('Дата окончания прибывания');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->date('start_check_date')->comment('Дата начала прибывания');
            $table->date('end_check_date')->comment('Дата окончания прибывания');
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('start_check_date');
            $table->dropColumn('end_check_date');
        });
    }
}
