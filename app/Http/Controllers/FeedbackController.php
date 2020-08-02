<?php

namespace App\Http\Controllers;

use App\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Mail;
use App\Mail\FeedbackMail;
use \Validator;

class FeedbackController extends Controller {


    public function send(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required'
        ]);
//        Mail::send('email',
//            array(
//                'name' => $request->get('name'),
//                'surname' => $request->get('surname'),
//                'subject' => $request->get('subject'),
//                'email' => $request->get('email'),
//                'user_message' => $request->get('message')
//            ), function($message )
//            {
//                $message->from('artem@crocos.kz');
//                $message->to('avp@crocos.kz', 'Admin')->subject('Заявка на подключение гостиницы');
//            });
       $ok =  \App\Request::create($request->all());
        return 'Отправлено';

    }

    public function notification(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'surname' => 'required',
            'status' => 'required'
        ]);
        if($request->status == 1) {
            Mail::send('notification',
                array(
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'email' => $request->email,
                ), function ($message) use ($request) {
                    $message->from('artem@crocos.kz');
                    $message->to($request->email)->subject('Welcome to Kazakhstan');
                });
        }
        if($request->status == 2) {
            Mail::send('notification_welcome',
                array(
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'email' => $request->email,
                ), function ($message) use ($request) {
                    $message->from('artem@crocos.kz');
                    $message->to($request->email)->subject('Welcome to Kazakhstan');
                });
        }
        return back()->with('success', 'Thanks for contacting us!');
    }

}
