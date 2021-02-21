<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrderedElements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordered_elements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_id')->nullable();
            
            $table->string('type')->nullable();
            $table->string('tolwina')->nullable();   
            $table->string('dlina')->nullable();   
            $table->string('wirina')->nullable();  
            $table->string('comment')->nullable();


            $table->integer('count')->nullable();              
            $table->date('date')->nullable();

            $table->integer('price')->nullable(); 

            $table->integer('amount_sum')->nullable();  
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
