<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\RoomSale;
use App\Models\RoomType;
use App\Models\User;
use Auth;
use Carbon\CarbonPeriod as CarbonPeriod;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function Complex\add;

class RoomSaleController extends Controller
{
    public function all(Request $request)
    {
        // if(!Auth::user()->hotels) {
        //     return response(['msg' => 'У вас нет полномочий!'], 200);
        // }
        $dateRange = CarbonPeriod::create(Carbon::now(), Carbon::now()->addMonth(1));

        $hotelUser = \Auth::user();
       
      
        if($hotelUser->hotels->count() == 0) {
            return response(['msg' => 'Не найдены отели!'], 200);
        }
       
        
        $room_types = RoomType::where('hotel_id', $hotelUser->hotels[0]->id)
            ->select('id', 'name')
            ->get();
        
        if($room_types->count() < 0) {
            return response(['msg' => 'Room type not exist!'], 200);
        }
        

        $dates = [];
        foreach ($dateRange as $date) {         // формируем дату
            $dates[] = $date->format('Y-m-d');  
        }
        $days = collect(new RoomSale); 

        for ($j = 0; $j <= count($dates) - 1; $j++) { // формируем объекты дней для брони
            $day = new RoomSale();
            $day->count = 0;
            $day->booked_count = 0;
            $day->room_type_id = 1;
            $day->date = $dates[$j];
            $days->add($day);
        }

        for($i = 0; $i < count($room_types); $i++) {
            $room_types[$i]->days = $days;        
        }

        return response(['rooms' => $room_types], 200);
    
    }



    public function allByFilter(Request $request)
    {

        $rules = [
            'room_type_id' => 'required|string',
            'date' => 'required|string'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response($validator->failed());
        }

        $hotelUser = \Auth::user();
       
      
        if($hotelUser->hotels->count() == 0) {
            return response(['msg' => 'Не найдены отели!'], 200);
        }


        $selectedDate = Carbon::createFromFormat('Y.m.d', $request->date);

        $dateRange = CarbonPeriod::create($selectedDate->format('Y-m-d'), $selectedDate->addMonth(1)->format('Y-m-d'));

        $dates = [];
        foreach ($dateRange as $date) {
            $dates[] = $date->format('Y-m-d');
        }

        $days = collect(new RoomSale);
        
       
        $roomType = RoomType::find($request->room_type_id)->first();
            
        for ($i = 0; $i <= count($dates) - 1; $i++) {
            $day = new RoomSale();
            $day->count = 0;
            $day->tarif_id = 1;
            $day->booked_count = 0;
            $day->room_type_id = $roomType->id;
            $day->date = $dates[$i];
            $days->add($day);
        }

        $res = RoomSale::whereIn('date', $dates)
            ->where('room_type_id', $request->room_type_id)
            ->get();
        
        $firstCollection = $days->keyBy('date');
        $secondCollection = $res->keyBy('date');
        $combined = $firstCollection->merge($secondCollection);
        $combined = $combined->values();
        return response(['id' => $roomType->id, 'name' => $roomType->name, 'days' => $combined], 200);
    }

    public function updateRoomSaleCount(Request $request)
    {
        $rules = [
            'rooms' => 'required|array',
            'room_type_id' => 'required|string',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response($validator->failed());
        }

        try {
            foreach ($request->rooms as $room) {

                $res = RoomSale::updateOrCreate(
                    [
                        'room_type_id' => $request->room_type_id,
                        'date' => $room['date']
                    ],
                    [
                        'tarif_id' => 1,
                        'room_type_id' => $request->room_type_id,
                        'date' => $room['date'],
                        'count' => $room['count'],
                        'booked_count' => 0,
                        'hotel_id' => Auth::user()->hotel_id
                    ]
                );
            }

            if ($res) {
                return response(['msg' => 'Room sale count success updated!'], 200);
            }
        }catch(Exception $e) {
            return response(['err' => $e->getMessage()], 200);
        }
        

       
    }
}
