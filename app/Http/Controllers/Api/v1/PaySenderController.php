<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\PaySender;
use App\Models\Feedback;
use App\Models\NewsImage;
use App\Models\News;
use App\Models\PayTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \Validator;
class PaySenderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function listByType(Request $request) {
        $user = DB::table('model_has_roles')->where('model_id', Auth::id())->get();
        $auth_role = $user[0]->role_id;
        
        $users = PaySender::orderBy('date_agreement', 'ASC')->where('type_agreement',$request->type_order)->with('user')->with("prices")->get();

        $array = [];
        $without_account = [];
        $sum = 0;

        for ($i=0; $i <count($users); $i++) { 
            if($users[$i]->user!=null) {
                
                $this->sumAmount($users[$i]->prices);
                $users[$i]->amount = $this->sumAmount($users[$i]->prices);

                array_push($array,$users[$i]);
            }
            else {
                array_push($without_account,$users[$i]);
            }
        }

        if($request->type==1) {
            return $array;
        }
        else {
            return $without_account;
        }

    }
    public function index(Request $request)
    {
     

        $user = DB::table('model_has_roles')->where('model_id', Auth::id())->get();
        $auth_role = $user[0]->role_id;
        
        $users = PaySender::orderBy('date_agreement', 'ASC')->where('type_agreement',1)->with('user')->with("prices")->get();

        // if($auth_role==1) {

            // return $users;
            $array = [];
            $without_account = [];
            $sum = 0;
            for ($i=0; $i <count($users); $i++) { 
                if($users[$i]->user!=null) {
                    
                    $this->sumAmount($users[$i]->prices);
                    $users[$i]->amount = $this->sumAmount($users[$i]->prices);
                    array_push($array,$users[$i]);
                }
                else {
                    array_push($without_account,$users[$i]);
                }
            }

            if($request->type==1) {
                return $array;
            }
       
    }

    public function withoutAccount(Request $request)
    {
        $user = DB::table('model_has_roles')->where('model_id', Auth::id())->get();
        $auth_role = $user[0]->role_id;
        
        $users = PaySender::orderBy('date_agreement', 'ASC')->with('user')->with("prices")->get();


        $array = [];
        $without_account = [];
        $sum = 0;
        for ($i=0; $i <count($users); $i++) { 
            if($users[$i]->user==null) {
                   
                array_push($without_account,$users[$i]);
            }
         
        }

        return $without_account;
    }

    public function sumAmount($array) {

        $sum = 0;
        for ($i=0; $i < count($array); $i++) { 
            $sum = $sum+$array[$i]->amount;
        }

        return $sum;

    }
    
    public function deletePaysender(Request $request) {
        $client = PaySender::query()->where('id',$request->client_id)->delete();
        $user = User::query()->where('client_id',$request->client_id)->delete();
        $price = PayTransaction::query()->where('client_id',$request->client_id)->delete();


        return [
            'success'=>'Успешно удален'
        ];
    }
    public function getOneTransaction(Request $request) {
        $price = PayTransaction::query()->where('client_id',$request->client_id)->where('id',$request->transactions_id)->first();

        return $price;

    }
    public function updateTransaction(Request $request) {
        $price = PayTransaction::query()->where('id',$request->id)->where('client_id',$request->client_id)->first();

        $price->amount = $request->amount;

        $price->type_of_transaction = $request->type_of_transaction;
        $price->date_of_transaction = $request->date_of_transaction;
        $price->number_payment = $request->number_payment;
        $price->street_of_bank   = $request->street_of_bank;
        $price->save();

        return [
            'success'=>'Успешно отредактирован'
        ];
    }
    public function deleteTransaction(Request $request) {
        $price = PayTransaction::query()->where('client_id',$request->client_id)->delete();

        return [
            'success'=>'Успешно удален'
        ];
    }

    public function update_data(Request $request) {


        $paySender = PaySender::query()->where('id',$request->client_id)->first();

        $paySender->name = $request->name;
        $paySender->surname = $request->surname;
        $paySender->patronymic = $request->patronymic;
        $paySender->iin =  $request->iin;
        $paySender->date_agreement =  $request->date_agreement;
        $paySender->warning =  $request->warning;

        $paySender->save();

        $user = User::query()->where('client_id',$request->client_id)->first();

        $user->email = $request->email;

        if($request->password!='') {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return [
            'success'=>'Успешно отредактирован'
        ];

    }

    public function getClient(Request $request) {
        $client = PaySender::query()->where('id',$request->id)->first();

        return $client;
    }

    public function sendTransaction(Request $request) {

        $client = PaySender::query()->where('id',$request->client_id)->first();


        $paytransaction = new PayTransaction;
        
    
        $paytransaction->client_id = $request->client_id;
        $paytransaction->number_payment = $request->number_payment;
        $paytransaction->amount = $request->amount;
        $paytransaction->type_of_transaction = $request->type_of_transaction;
        $paytransaction->street_of_bank = $request->street_of_bank;
        $paytransaction->date_of_transaction = $request->date_of_transaction;

      
        $month = explode("-",$request->date_of_transaction)[1];
        $year =  explode("-",$request->date_of_transaction)[0];


        $day = explode("-",$client->date_agreement)[2];


        $create = $year.'-'.$month.'-'.$day;


        $first = Carbon::parse($request->date_of_transaction);

        $second = Carbon::parse($create);

        if($first->lessThanOrEqualTo($second)) {
            if($paytransaction->save()) {
                return response()->json(['success' => "Успешно добавлен транзакция"], 200);
            }
        }
        else {
            $m = intval(explode("-",$client->date_agreement)[1]);
            $m = $m+1;
            $client->warning = $client->warning+1;
            $client->date_agreement = $year.'-'.$m.'-'.$day;

            $client->save();
            
            if($client->warning==1) {
                return response()->json(['success' => "Очеред продлен на 1 месяць"], 200);
            }
            else if($client->warning==2) {
                return response()->json(['success' => "Очеред продлен на 2 месяца напоминаем клиент следующий раз будет удален из списка"], 200);
            }
            else if($client->warning>2) {
                $client = PaySender::query()->where('id',$request->client_id)->delete();
                $user = User::query()->where('client_id',$request->client_id)->delete();
                $price = PayTransaction::query()->where('client_id',$request->client_id)->delete();

                return response()->json(['success' => "Пользователь удален из списка"], 200);

            }
        }


    }




    public function getTransactions(Request $request) {
        $paytransactions = PayTransaction::query()->where('client_id',$request->id)->get();

        return json_encode($paytransactions);
    }


    public function deleteFeedback(Request $request) {

        $feedback = Feedback::where("id",$request->id)->delete();

        if($feedback) {
            return response()->json(["success"=>"Успешно удален"], 200);
        }
        else {
            return response()->json(["error"=>"Ошибка"], 422);
        }
    }
    public function getFeedback(Request $request) {
        $feedback = Feedback::orderBy('date', 'ASC')->get();
        return response()->json(["success"=>$feedback], 200);
    }
    public function sendFeedbackUser(Request $request) {
        $feedback = new Feedback();

        $feedback->title = $request->title;
        $feedback->description = $request->description;
        $feedback->url_video = $request->url_video;
        $feedback->date = $request->date;

        $feedback->save();

        return response()->json($feedback, 200);
    }
    public function sendFeedbackClient(Request $request) {
        $feedback = new Feedback();

        //  $feedback->id = $request->id;
         $feedback->title = $request->title;
         $feedback->description = $request->description;
        //  $feedback->url_video = $request->url_video;
         $feedback->date = $request->date;

         $feedback->save();



        return response()->json($feedback, 200);
    }

    public function deleteImageNews(Request $request) {
        $delete_news = NewsImage::where("news_id",$request->id)->delete();


        return response()->json(['success' => "Успешно удален рисунок новости"], 200);
        
    }
    public function uploadImageNews(Request $request) {
        
        // $news = News::where('id', $request->input('news_id'))->first();

        // if (!$news) {
        //     return response()->json(['error' => 'Ошибка, Нет такой новости'], 400);
        // }
        
        $get_id = News::orderBy('id','DESC')->select('id')->first();

       
        $newsImage = new NewsImage();

        $request->validate([
            'image' => 'mimes:jpg,jpeg,png,bmp,tiff',
        ]);

        
        $extension = $request->image->getClientOriginalExtension();
        $path = 'storage/hotel/images/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';
        $file = 'hotel-image-' . time() . '.' . $extension;
        $request->image->move($path, $file);

        $newsImage->image = '/' . $path . $file;
        $newsImage->thumbnail = '/' . $path . $file;
        $newsImage->news_id = $get_id->id;
        $result = $newsImage->save();
            
        return response()->json($result, 200);
    }


    public function getNews(Request $request) {    
        $get_news = News::orderBy('date', 'ASC')->with("news_image")->get();

        return response()->json(["data" => $get_news,"host"=>env('APP_URL')], 200);
    }
    public function createNews(Request $request) {
        
        $insert_news = new News();

        $insert_news->title = $request->title;
        $insert_news->description = $request->description;
        $insert_news->date = $request->date;

        $get_id = News::orderBy('date','ASC')->select('id')->first();

        if($insert_news->save()) {
            return response()->json(['success' => "Успешно добавлен новость",'id'=>$get_id], 200);
        }
        else {
            return response()->json(['error' => "Ошибка при добавление новости"], 422);
        }
        
    }

    public function createFeedback(Request $request) {
        
        $insert_feedback = new Feedback();

        $insert_feedback->title = $request->title;
        $insert_feedback->description = $request->description;
        $insert_feedback->url_video = $request->url_video;
        $insert_feedback->date = $request->date;

        
        if($insert_feedback->save()) {
            return response()->json(['success' => "Успешно добавлен новость"], 200);
        }
        else {
            return response()->json(['error' => "Ошибка при добавление новости"], 422);
        }
        
    }
  
    public function deleteNews(Request $request) {
        $delete_image  = NewsImage::where('news_id',$request->id)->delete();
        $delete_news  = News::where('id',$request->id)->delete();

        if($delete_news) {
            return response()->json(['success' => "Успешно удален новости"], 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
           
            'name'=> 'required',
            'surname'=> 'required',
            'document_number'=> 'required',
            'date_of_given'=> 'required',
            'end_of_given'=> 'required',
            'phone'=> 'required',
            'iin'=> 'required|unique:paysender',
            'type_agreement'=> 'required',
            'date_agreement'=> 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

        
        $paySender = PaySender::create($request->all());
     
        return response()->json(['success' => "Успешно добавлен пользователь"], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PaySender  $paySender
     * @return \Illuminate\Http\Response
     */
    public function show(PaySender $paySender)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PaySender  $paySender
     * @return \Illuminate\Http\Response
     */
    public function edit(PaySender $paySender)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaySender  $paySender
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaySender $paySender)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PaySender  $paySender
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaySender $paySender)
    {
        //
    }
}
