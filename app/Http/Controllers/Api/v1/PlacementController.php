<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PlacementController extends Controller
{
    /*-----------------------------
    |    Вывод всех гостиниц      |
    -----------------------------*/

    public function hotel(Request $request) {
        $hotel = \App\Models\Hotel::where('id', $request->input('hotelId'))->first();
        $typeRoom = DB::table(hotel_room_types)->where('hotel_id', $hotel->id)->get();
        
        return response()->json([
            'hotel' => $hotel,
            'typeRoom' => $typeRoom
        ]);
    }
}
