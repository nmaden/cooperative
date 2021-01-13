<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Podezd;
use App\Models\Etaj;
use App\Models\Kvartira;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class ApartmentController extends Controller
{
    public function index()
    {
    
    }
    public function edit(Request $request) {

        $user = DB::table('model_has_roles')->where('model_id', Auth::id())->get();
        $auth_role = $user[0]->role_id;

        if($auth_role!=1) {
            return response()->json(['error' => "Permission denied"], 422);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'surname' => 'required',
            'iin' => 'required',
            'phone' => 'required',
            'podezd' => 'required',
            'etaj' => 'required',
            'kvartira' => 'required',
            'ordered'=>'required',
            'amount'=>'required',
            'ordered'=>'required'
          ]);
          
          
  
          if ($validator->fails()) {
              return response()->json(['error' => $validator->messages()], 422);
          }

          if($request->ordered==false) {
            $request->name = '';
            $request->surname = '';
            $request->iin = '';
            $request->phone = '';
            $request->amount = 0;
          }
          $order =  Kvartira::query()
          ->where("kvartira",$request->kvartira)
          ->where("etaj_id",$request->etaj)
          ->where("podezd_id",$request->podezd)
          ->first();
  
          $order->name = $request->name;
          $order->surname = $request->surname;
          $order->iin = $request->iin;
          $order->phone = $request->phone;
         
          $order->amount = $request->amount;
          
          $order->ordered = $request->ordered;
  
          $order->save();
          return response()->json(['status' => 200,'message'=>'Успешно отредактирован']);
    }
    public function create(Request $request)
    {   
   
        // for ($i=1; $i <=3 ; $i++) {
        //     $podezd = new Podezd();
 
        //     $podezd->podezd = $i;
        //     $podezd->save();
        // }

        // 1 2 3

        // 1 2 3 4 5 

        // 1 2 3   1 2 3   1 2 3   1 2 3   1 2 3 

        // name surname iin phone 
        
        for ($i=1; $i<=3 ; $i++) { 
            
            for ($j=1; $j <=5; $j++) { 
                
                for ($k=1; $k <=3; $k++) { 
                    $etaj = new Kvartira();
                    $etaj->etaj_id = $j;
                    $etaj->kvartira = $k;
                    $etaj->podezd_id = $i;
                
                    $etaj->save();
                }
               
            }
        }
    }
    public function get(Request $request)
    {
        $kv = [];
        $result = Kvartira::query()->where("etaj_id",$request->etaj)->get();
        
        for ($i=1; $i <=3; $i++) { 
            
            $result = Kvartira::query()->where("etaj_id",$request->etaj)->where("podezd_id",$i)->get();
        
            if(array_key_exists($i, $kv)) {
                for ($j=0; $j <count($result); $j++) { 
                    array_push($kv[$i],$result[$j]);
                }
                
            }
            else {
                $kv[$i]=[];
                for ($j=0; $j <count($result); $j++) { 
                    array_push($kv[$i],$result[$j]);
                }
            }
        }
      
        return $kv;
    }
    public function order(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'name' => 'required',
          'surname' => 'required',
          'iin' => 'required',
          'phone' => 'required',
          'podezd' => 'required',
          'etaj' => 'required',
          'kvartira' => 'required',
          'ordered'=>'required',
          'amount'=>'required'
        ]); 

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

        $order =  Kvartira::query()
        ->where("kvartira",$request->kvartira)
        ->where("etaj_id",$request->etaj)
        ->where("podezd_id",$request->podezd)
        ->first();

        $order->name = $request->name;
        $order->surname = $request->surname;
        $order->iin = $request->iin;
        $order->phone = $request->phone;
       
        $order->amount = $request->amount;
        
        $order->ordered = $request->ordered;

        $order->save();
        return response()->json(['status' => 200,'message'=>'Успешно забронирован']);
    }
}
