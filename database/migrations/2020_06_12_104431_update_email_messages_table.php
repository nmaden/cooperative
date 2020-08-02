<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEmailMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        \DB::table('email_messages')->truncate();

        Schema::table('email_messages', function (Blueprint $table) {
            $table->dropColumn('welcome_text');
            $table->dropColumn('farewell_text');
            $table->dropColumn('instant_text');
            $table->dropForeign('email_messages_hotel_id_foreign');
            $table->dropColumn('hotel_id');
            
            $table->longText('text')->after('appeal');
            $table->enum('type', ['upon_booking', 'upon_arrival', 'upon_departure'])->after('text');
            $table->integer('check_in_day_notice')->after('type');
            $table->integer('check_out_day_notice')->after('check_in_day_notice');    
        });

        \DB::table('email_messages')->insert([
            'color' => '#FFCE03',
            'appeal' => 'Здравсвуйте',
            'text' => 'Напоминаем',
            'type' => 'upon_booking',
            'check_in_day_notice' => 1,
            'check_out_day_notice' => 1,
            'subject_text' => 'Тема письма',
            'status_booking' => 1,
            'status_pay' => 1,
            'status_cancel' => 1,
            'status_weather' => 0,
            'signature_text' => 'Подпись',
            'test_email' => 'avp@crocos.kz'
            // 'created_at' => \now(),
            // 'updated_at' => \now(),
        ]);

        \DB::table('email_messages')->insert([
            'color' => '#FFCE03',
            'appeal' => 'Здравсвуйте',
            'text' => 'Напоминаем',
            'type' => 'upon_arrival',
            'check_in_day_notice' => 1,
            'check_out_day_notice' => 1,
            'subject_text' => 'Тема письма',
            'status_booking' => 1,
            'status_pay' => 1,
            'status_cancel' => 1,
            'status_weather' => 0,
            'signature_text' => 'Подпись',
            'test_email' => 'avp@crocos.kz'
            // 'created_at' => \now(),
            // 'updated_at' => \now(),
        ]);

        \DB::table('email_messages')->insert([
            'color' => '#FFCE03',
            'appeal' => 'Здравсвуйте',
            'text' => 'Напоминаем',
            'type' => 'upon_departure',
            'check_in_day_notice' => 1,
            'check_out_day_notice' => 1,
            'subject_text' => 'Тема письма',
            'status_booking' => 1,
            'status_pay' => 1,
            'status_cancel' => 1,
            'status_weather' => 0,
            'signature_text' => 'Подпись',
            'test_email' => 'avp@crocos.kz'
            // 'created_at' => \now(),
            // 'updated_at' => \now(),
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('email_messages', function (Blueprint $table) {
            $table->dropColumn('text');
            $table->dropColumn('type');
            $table->dropColumn('check_in_day_notice');
            $table->dropColumn('check_out_day_notice');
        });
    }
}
