<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameLowAndContactInfoAndCoordinateOnMapToHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->string('contact_info');
            $table->string('coortdinate_on_map');
            $table->boolean('service_wifi')->default(0);
            $table->boolean('service_breakfast')->default(0);
            $table->boolean('service_reseption_round_day')->default(0);
            $table->boolean('service_daily_cleaning')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropColumn('contact_info');
            $table->dropColumn('coortdinate_on_map');
            $table->dropColumn('service_wifi');
            $table->dropColumn('service_breakfast');
            $table->dropColumn('service_reseption_round_day');
            $table->dropColumn('service_daily_cleaning');
        });
    }
}
