<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kvartira', function (Blueprint $table) {
         
            $table->string('name')->nullable()->change();
            $table->string('surname')->nullable()->change();
            $table->string('phone')->nullable()->change();
            $table->string('amount')->nullable()->change();
            $table->string('iin')->nullable();
          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kvartira', function (Blueprint $table) {
            //
        });
    }
}
