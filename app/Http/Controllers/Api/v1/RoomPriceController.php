<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\RoomType;
use App\Models\DailyPrice;
use Carbon\Carbon;

class RoomPriceController extends Controller
{
    public function show(Request $request) {
        $user = \App\Models\User::where('id', Auth::user()->id)
            ->with('roles')
            ->with('responsible')
            ->first();

        $role_id = $user->roles[0]->id;

        if ($role_id === 4 || $role_id === 5) {
            
            $hotelUser = DB::table('hotel_user')
                ->where('user_id', Auth::user()->id)
                // ->where('hotel_id', $request->input('hotel_id'))
                ->first();
        
            if (!$hotelUser) {
                return response()->json(['error' => 'У вас нет полномочии на эту гостиницу'], 400);
            }
        } else {
            return response()->json(['error' => 'У вас нет полномочии на эту Гостиницу'], 400);
        }
        
        
        $roomType = \App\Models\RoomType::where('id', $request->input('id'))
            ->where('hotel_id', $hotelUser->hotel_id)
            ->first();

        if(!$roomType) return response()->json(['error' => 'Ошибка, Нет такого типа номера'], 400);

        $month = intval($request->input('month'));
        $year = intval($request->input('year'));
        $last_day = intval($request->input('last_day'));

        $date = Carbon::createFromDate($year, $month, $day = null, $tz = null);
        $month = $date->format('m');
        

        // if ($year % 4 !== 0 && $month == 2) {
        //     $date = Carbon::createFromDate($year, $month, $day = null, $tz = null);
        //     $lastDay = '28';
        //     $lastDayFormat = $year . '-' . $month . '-' . $lastDay;
        //     $firstDayFormat = $year . '-' . $month . '-' . '01';
        // } else {
        //     $date = Carbon::createFromDate($year, $month, $day = null, $tz = null);
        //     $lastDay = $date->modify('last day of this month')->format('d');
        //     $lastDayFormat = $year . '-' . $month . '-' . $lastDay;
        //     $firstDayFormat = $year . '-' . $month . '-' . '01';
        // }

        $lastDayFormat = $year . '-' . $month . '-' . $last_day;
        $firstDayFormat = $year . '-' . $month . '-' . '01';

        $dailyPrice = $roomType->dailyPrice
            ->where('date', '<=', $lastDayFormat)
            ->where('date', '>=', $firstDayFormat);

       

        return response()->json([
            'roomTypeDays' => $dailyPrice
        ], 200);
    }

    public function edit(Request $request) {
        $user = \App\Models\User::where('id', Auth::user()->id)
            ->with('roles')
            ->with('responsible')
            ->first();

        $role_id = $user->roles[0]->id;

        if ($role_id === 4 || $role_id === 5) {
            $hotelUser = DB::table('hotel_user')
                ->where('user_id', Auth::user()->id)
                // ->where('hotel_id', $request->input('hotel_id'))
                ->first();
        
            if (!$hotelUser) {
                return response()->json(['error' => 'У вас нет полномочии на эту гостиницу'], 400);
            }
        } else {
            return response()->json(['error' => 'У вас нет полномочии на эту Гостиницу'], 400);
        }

        $roomType = \App\Models\RoomType::where('id', $request->input('id'))
            ->where('hotel_id', $hotelUser->hotel_id)
            ->first();
        if (!$roomType) return response()->json(['error' => 'Нет такого типа номера']);

        $month = $request->input('month');
        $year = $request->input('year');
        $last_day = $request->input('last_day');

        $date = Carbon::createFromDate($year, $month, $day = null, $tz = null);
        $month = $date->format('m');

       



        for ($day = 1; $day <= $last_day; $day++) {
            // if ($request->has('day' . $day)) {
                $dailyPrice = DailyPrice::where('room_type_id', $roomType->id)->where('date', $year . '-' . $month . '-' . $day)->first();
                if (!$dailyPrice) $dailyPrice = new DailyPrice;
                $dailyPrice->date= $year . '-' . $month . '-' . $day;
                $dailyPrice->room_type_id = $roomType->id;
                $dailyPrice->price = $request->input('prices')[$day-1];
                $dailyPrice->price_per_person = $request->input('price_per_person')[$day-1];
                $dailyPrice->save();
            // }
        }
        return response()->json(['success' => 'Успешно сохранен'], 200);

        // return response()->json(['error' => 'Ошибка, Заполните все поля'], 400);
    }


}
