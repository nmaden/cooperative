<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class emailMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email-message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $emailMessages = \DB::table('email_messages')->get();
        foreach ($emailMessages as $emailMessage) {

            if ($emailMessage->type === 'upon_booking') {
                $time = time() + 60 * 60 * 24 * $emailMessage->check_in_day_notice;
            }
            if ($emailMessage->type === 'upon_arrival') {
                $time = time() - 60 * 60 * 24 * $emailMessage->check_in_day_notice;
            }
            if ($emailMessage->type === 'upon_departure') {
                $time = time();
            }

            $transactions = \App\Models\Transaction::query()
                ->where(
                    ($emailMessage->type === 'upon_departure' ? 'check_in' : 'check_out'),
                    '>',
                    date('Y-m-d 00:00:00', $time)
                )
                ->where(
                    ($emailMessage->type === 'upon_departure' ? 'check_in' : 'check_out'),
                    '<',
                    date('Y-m-d 23:59:59', $time)
                )
                ->get();

            foreach ($transactions as $transaction) {

                $checkIn = strtotime($transaction->check_in);
                $checkOut = strtotime($transaction->check_out);

                $differenceNight =  floor(($checkOut - $checkIn) / (60 * 60 * 24));

                $emailMessage->text = strtr($emailMessage->text, [
                    '#nameHotel' => $transaction->hotel->name
                ]);

                $emailMessage->appeal = strtr($emailMessage->appeal, [
                    '#name' => $transaction->client->name,
                    '#surname' => $transaction->client->surname,
                    '#patronymic' =>$transaction->client->patronymic
                ]);

                $emailMessage->signature_text = strtr($emailMessage->signature_text, [
                    '#nameHotel' => $transaction->hotel->name
                ]);

                $templateData = [
                    'transaction' => $transaction,
                    'emailProperties' => $emailMessage,
                    'differenceNight' => $differenceNight
                ];

                $messageData = [
                    // '#nameHotel' => $transaction->name,
                ];

                if ($emailMessage->type === 'upon_booking') {
                    $db1 = time(); 
                    $db2 = strtotime($transaction->check_in);
                    $ddifferent = floor(($db2 - $db1) / (60 * 60 * 24));
                    $messageData['#daysBeforeArrival'] = $templateData['daysAtHotel'] = $ddifferent;
                }

                
                

                // return view('emails\notification', $templateData);

                Mail::send('emails.notification', $templateData, 
                    function ($m) use ($transaction, $emailMessage) {
                    $m->from(getenv('MAIL_FROM_ADDRESS'), getenv('MAIL_FROM_NAME'));
                    $m->to($transaction->client->email, 'hotel')->subject($emailMessage->subject_text);
                });
            }
            
            
        }
    }
}
