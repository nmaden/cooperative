<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Message;
use App\User;
use App\Notifications\NewMessage;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public $user;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $message = new Message;
        $message->setAttribute('from', 'info@eqonaq.kz');
        $message->setAttribute('to', $this->$user);
        $message->setAttribute('message', 'Demo message from user 2 to user 1.');
        $message->save();

        $fromUser = User::find(2);
        $toUser = User::find(1);


        $toUser->notify(new NewMessage($fromUser));


        Notification::send($toUser, new NewMessage($fromUser));
    }
}