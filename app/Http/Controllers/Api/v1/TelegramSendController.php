<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Validator;
use App\Models\Transaction;

class TelegramSendController extends Controller
{

    public function send_message(Request $request) {
      $validator = Validator::make($request->all(), [
        'name' => 'required',
        'phone' => 'required'
      ]); 
      if ($validator->fails()) {
          return response()->json(['error' => $validator->messages()], 422);
      }

      $phone = '+7'.substr($request->phone,1,strlen($request->phone));

      $link = "https://wa.me/".$phone."";

      $message = '+7'.substr($request->phone,1,strlen($request->phone)).' '.$request->name.' '.$link;
      
    
      $this->send_telegram(281900870,$message); // I
      $this->send_telegram(891800093,$message); // Wamwi
      $this->send_telegram(635324651,$message); // Menedjer
    }
    public function send_telegram($id,$message)
    {
 

        $token = 'bot1517788888:AAG9eb2pycBhQy1XARFvgyKQs8YMk1nTvJo';
        $chat_id = $id;
      
        $url = "https://api.telegram.org/$token/sendMessage?chat_id=$chat_id&text=$message";

        $ch = curl_init();

        $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true  
        );
  

        curl_setopt_array($ch, $optArray);
        $result = curl_exec($ch);

        $err = curl_error($ch);
        curl_close($ch);    


        return $result;
     
    }
}
