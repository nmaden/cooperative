<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use App\Models\Country;
use Illuminate\Http\Request;
use PDF;
use App\Models\Calculations;
use App\Models\OrderedElements;
use App\Models\KenesOrder;
use App\Models\TypeCalculate;

class CreateCalcElement extends Controller
{
    public function index(Request $request) {
      

        // $calculations = Calculations::query()->with('type_calculate')->get();


        // return $calculations;
    }

    public function set_order(Request $request) {
        $calculations = new KenesOrder();

        $calculations->who =  $request->user_name;
        $calculations->amount =  $request->amount;
        $calculations->comment =  $request->comment;
        $calculations->user_id =  $request->user_id;


        $calculations->save();

        $ordered_elements = new OrderedElements();

        $ordered_elements->order_id =  $calculations->id;
        $ordered_elements->type =  $request->amount;
        $ordered_elements->comment =  $request->comment;
        $ordered_elements->user_id =  $request->user_id;


        $ordered_elements->save();


        return $calculations;
    }

    public function get() {
        $calculations = Calculations::query()->with('type_calculate')->get();
        return $calculations;
    }

    public function getAllOrder() {
        $kenes_order = KenesOrder::query()->with("ordered_elements")->get();
        return $kenes_order;

        
    }

    public function saveOrder(Request $request) {
    
        $kenes_order = KenesOrder::query()->where("id",$request->orders["id"])->first();

        $kenes_order->amount = $request->orders["amount"];

        $kenes_order->save();

        for ($i=0; $i < count($request->ordered_elements) ; $i++) { 
            $ordered_elements = OrderedElements::query()->where("id",$request->ordered_elements[$i]["id"])->first();

            $ordered_elements->price = $request->ordered_elements[$i]["price"];

            $ordered_elements->save();

        }
        

        return response()->json(['msg' => "Заказ успешно сохранен"], 200);
    }

   
    public function showKenesReference(){
        
      
        $journal = 1;
        $pdf = PDF::loadView('pdf_reference',  ['qr' => 3,
            'id' => 2,
            'name' =>1]);
        header('Content-Type: application/pdf');
    
        return $pdf->save();

       
    }

    public function createOrder(Request $request) {

        
   
    
        $kenes_order = new KenesOrder();
        $kenes_order->who = "User";
        $kenes_order->comment = "text";
        $kenes_order->user_id = 1;
        $kenes_order->height = $request->height;

        $kenes_order->save();
     

        foreach ($request->data as $key => $value) {

            $ordered_elements = new OrderedElements();

            if($value["type_calculate"]=='by_count') {
                $ordered_elements->count = $value["count"];
                $ordered_elements->size = $value["volume"];

                $ordered_elements->image_path = $value["image_path"];
                $ordered_elements->type_calculate = $value["type_calculate"];
                $ordered_elements->type = $value["id"];
                $ordered_elements->type_name = $value["name"];
                $ordered_elements->order_id = $kenes_order["id"];
                $ordered_elements->save();
            }
            else {
                $ordered_elements->dlina = $value["dlina"];
                $ordered_elements->wirina = $value["wirina"];
                $ordered_elements->count = $value["count"];
                $ordered_elements->size = $value["volume"];

                $ordered_elements->image_path = $value["image_path"];
                $ordered_elements->type_calculate = $value["type_calculate"];
                $ordered_elements->type = $value["id"];
                $ordered_elements->type_name = $value["name"];
                $ordered_elements->order_id = $kenes_order["id"];
                $ordered_elements->save();
            }

           
          
        }

        return response()->json(['msg' => "Успешно создан"], 200);
    }
    public function getElement(Request $request) {
        $calculations = Calculations::where("id",$request->id)->first();

        return response()->json(['data' => $calculations], 200);
    }
    public function getCalc(Request $request) {
        $type_calculate = TypeCalculate::query()->where('id',$request->id)->first();

        return response()->json(['data' => $type_calculate], 200);
    }
    public function editElement(Request $request) {
        $calculations = Calculations::query()->where('id',$request->id)->first();
        $calculations->type = $request->type;
        $calculations->name = $request->name;

        $calculations->save();
        return response()->json(['message' => "Успешно отредактирован"], 200);
    }
    public function editCalc(Request $request) {

        $type_calculate = TypeCalculate::query()->where('id',$request->id)->first();

        
        $type_calculate->name = $request->name;
        $type_calculate->comment = $request->comment;
        $type_calculate->type_calculate = $request->type_calculate;
        $type_calculate->price = $request->price;
        
        $type_calculate->save();
        return response()->json(['message' => "Успешно отредактирован"], 200);
    }
    public function deleteElement(Request $request) {

        $calculations = Calculations::query()->where('id',$request->id)->delete();
        $type_calculate = TypeCalculate::query()->where('calculation_id',$request->id)->delete();

        return response()->json(['message' => "Успешно удален"], 200);
    }
    public function deleteCalc(Request $request) {

        $type_calculate = TypeCalculate::query()->where('id',$request->id)->delete();

        return response()->json(['message' => "Успешно отредактирован"], 200);
    }
    public function create(Request $request) {
        
        $exist_calc = Calculations::query()->where("type",$request->type)->first();
        
        if($exist_calc) {
            

            if($request->image!='') {
                $request->validate([
                    'image' => 'mimes:jpg,jpeg,png,bmp,tiff',
                ]);
            }
           
            $extension = $request->image->getClientOriginalExtension();
            
            $path = 'storage/hotel/images/' . $request->type.'/';
            $file = 'calc-image-' . time() . '.' . $extension;
            $request->image->move($path, $file);
            
            $type_calculate = new TypeCalculate();
       
        
            $type_calculate->calculation_id = $exist_calc->id;

            if($request->type=='Фрезировка' || $request->type=='Пленка') {
                $type_calculate->type = $request->type_of_el;
            }
            $type_calculate->comment= $request->comment;
            $type_calculate->type_calculate = $request->type_calc;
            $type_calculate->name = $request->name;

            $type_calculate->price = $request->price;
            $type_calculate->image_path = '/' . $path . $file;

            $type_calculate->save();


            return response()->json(['message' => "Success"], 200);

        }
        else {
      

            $calculations = new Calculations();

            $calculations->type = $request->type;
            $calculations->name = $request->name;

            $calculations->save();


            // return response()->json(['message' => $calculations], 200);
            
            $request->validate([
                'image' => 'mimes:jpg,jpeg,png,bmp,tiff',
            ]);
            $extension = $request->image->getClientOriginalExtension();
            
            $path = 'storage/hotel/images/' . $request->type.'/';
            $file = 'calc-image-' . time() . '.' . $extension;
            $request->image->move($path, $file);
            
            $type_calculate = new TypeCalculate();
       
        
            $type_calculate->calculation_id = $calculations->id;
            $type_calculate->type = $request->type;
            $type_calculate->comment= $request->comment;
            $type_calculate->type_calculate = $request->type_calc;
            $type_calculate->name = $request->name;

            $type_calculate->price = $request->price;
            $type_calculate->image_path = '/' . $path . $file;

            $type_calculate->save();



            return response()->json(['message' => "Success"], 200);

            

        }
       
        
    }

   
}
