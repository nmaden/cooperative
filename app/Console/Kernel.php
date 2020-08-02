<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\User;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        Commands\emailMessages::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('email-message')->daily();

            
                // $transaction->client->email;
                // $user = User::findOrFail($id);

                // Mail::send('email.notification-reservation', ['user' => $user], function ($m) use ($user) {
                //     $m->from('hello@app.com', 'Your Application');

                //     $m->to($transaction->client->email, $user->name)->subject('Your Reminder!');
                // });
            // file_put_contents(public_path() . '/../resources/views/test.txt', "Slue\n" , FILE_APPEND | LOCK_EX);
    }
}
