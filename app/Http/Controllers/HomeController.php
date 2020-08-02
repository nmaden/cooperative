<?php

namespace App\Http\Controllers;

use App\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Kato;
// use App\Models\EmailMessage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('landing', [
            'regions' => Kato::query()->where('level', 2)->get()
        ]);
    }

    public function requestRegister(Request $request) {

    }

//    public function test()
//    {
//     // $emailMessages = \App\Models\EmailMessage::get();
//     $emailMessages = DB::table('email_messages')->get();
//     foreach ($emailMessages as $emailMessage) {

//         if ($emailMessage->type === 'upon_booking') {
//             $time = time() + 60 * 60 * 24 * $emailMessage->check_in_day_notice;
//         }
//         if ($emailMessage->type === 'upon_arrival') {
//             $time = time() - 60 * 60 * 24 * $emailMessage->check_in_day_notice;
//         }
//         if ($emailMessage->type === 'upon_departure') {
//             $time = time();
//         }

//         $transactions = \App\Models\Transaction::query()
//             ->where(
//                 ($emailMessage->type === 'upon_departure' ? 'check_in' : 'check_out'),
//                 '>',
//                 date('Y-m-d 00:00:00', $time)
//             )
//             ->where(
//                 ($emailMessage->type === 'upon_departure' ? 'check_in' : 'check_out'),
//                 '<',
//                 date('Y-m-d 23:59:59', $time)
//             )
//             ->get();
//         foreach ($transactions as $transaction) {

//             $messageData = [
//                 '#nameHotel' => $transaction->name,
//             ];
            
            

//             if ($emailMessage->type === 'upon_booking') {
//                 $db1 = time(); 
//                 $db2 = strtotime($transaction->check_in);
//                 $ddifferent = floor(($db2 - $db1) / (60 * 60 * 24));

//                 $messageData['#daysBeforeArrival'] = $templateData['#daysAtHotel'] = $ddifferent;
//             }
            
//             $templateData = [
//                 'transaction' => $transaction,
//                 'emailProperties' => $emailMessage,
//                 'daysAtHotel' => $ddifferent
//             ];

//             $emailMessage->text = strtr($emailMessage->text, $messageData);

//             $emailMessage->appeal = strtr($emailMessage->appeal, [
//                 '#firstName' => $transaction->client->name,
//                 '#lastName' => $transaction->client->surname,
//             ]);

//             $emailMessage->signature_text = strtr($emailMessage->signature_text, [
//                 '#nameHotel' => $transaction->hotel->name
//             ]);

//             return view('emails\notification', $templateData);

//             // Mail::send('emails\notification', $templateData, 
//             //     function ($m) use ($transaction) {
//             //     $m->from(getenv('MAIL_FROM_ADDRESS'), getenv('MAIL_FROM_NAME'));
//             //     $m->to($transaction->client->email, 'hotel')->subject($emailMessage->subject_text);
//             // });
//         }
        
        
//     }
//    }


    // public function testWelcome(){
    //     $hotelUser = DB::table('hotel_user')->where('user_id',Auth::User()->id)->first();
    //     $emailProperties = EmailMessage::where('hotel_id', $hotelUser->hotel_id)->first();
    //     $hotel = DB::table('hotels')->where('id', $hotelUser->hotel_id)->first();

    //     $emailProperties->welcome_text = strtr($emailProperties->welcome_text, [
    //         '#nameHotel' => $hotel->name,
    //     ]);


    //     $emailProperties->signature_text = strtr($emailProperties->signature_text, [
    //         '#nameHotel' => $hotel->name
    //     ]);

    //     return view('emails\notification-test-welcome', [
    //         'hotel' => $hotel,
    //         // 'daysAtHotel' => $ddifferent, 
    //         // 'typeMessage' => 'welcome',
    //         'emailProperties' => $emailProperties
    //     ]);

    //     Mail::send('emails\notification-test-welcome', [
    //                     'hotel' => $hotel,
    //                     'emailProperties' => $emailProperties
    //                 ], 
    //                 function ($m) use ($hotelUser) {
    //                 $m->from('eqonaq@example.com', 'Your Application');
    //                 $m->to('$emailProperties->email', 'hotel')->subject('$emailProperties->subject_text');
    //             });
    // }

    // public function testFarewell() {
    //     $hotelUser = DB::table('hotel_user')->where('user_id',Auth::User()->id)->first();
    //     $emailProperties = EmailMessage::where('hotel_id', $hotelUser->hotel_id)->first();
    //     $hotel = DB::table('hotels')->where('id', $hotelUser->hotel_id)->first();
    //     $hotelEmail = DB::table('clients')->where('hotel_id', $hotelUser->hotel_id)->first();
        

    //     $emailProperties->farewell_text = strtr($emailProperties->farewell_text, [
    //         '#nameHotel' => $hotel->name,
    //     ]);

    //     $emailProperties->signature_text = strtr($emailProperties->signature_text, [
    //         '#nameHotel' => $hotel->name
    //     ]);

    //     return view('emails\notification-test-farewell', [
    //         'hotel' => $hotel,
    //         'emailProperties' => $emailProperties
    //     ]);

    //     Mail::send('emails\notification-test-farewell', [
    //                     'hotel' => $hotel,
    //                     'emailProperties' => $emailProperties
    //                 ], 
    //                 function ($m) use ($hotelUser) {
    //                 $m->from('eqonaq@example.com', 'Your Application');
    //                 $m->to('$emailProperties->email', 'hotel')->subject('$emailProperties->subject_text');
    //             });

    // }

    // public function testInstant() {
    //     $hotelUser = DB::table('hotel_user')->where('user_id',Auth::User()->id)->first();
    //     $emailProperties = EmailMessage::where('hotel_id', $hotelUser->hotel_id)->first();
    //     $hotel = DB::table('hotels')->where('id', $hotelUser->hotel_id)->first();

    //     $emailProperties->instant_text = strtr($emailProperties->instant_text, [
    //         '#nameHotel' => $hotel->name,
    //     ]);

    //     $emailProperties->signature_text = strtr($emailProperties->signature_text, [
    //         '#nameHotel' => $hotel->name
    //     ]);

    //     return view('emails\notification-test-instant', [
    //         'hotel' => $hotel,
    //         'emailProperties' => $emailProperties
    //     ]);

    //     Mail::send('emails\notification-test-instant', [
    //                     'hotel' => $hotel,
    //                     'emailProperties' => $emailProperties
    //                 ], 
    //                 function ($m) use ($hotelUser) {
    //                 $m->from('eqonaq@example.com', 'Your Application');
    //                 $m->to('$emailProperties->email', 'hotel')->subject('$emailProperties->subject_text');
    //             });        
    // }

    // public function base64(Request $request)
    // {
    //     if ($request->hasFile('file')) {
    //         $image = base64_encode(file_get_contents($request->file('file')));
    //         return response()->json( 'data:image/jpeg;base64,'.$image, 200);
    //     }
    // }
}
