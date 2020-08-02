<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use App\Models\DailyPrice;
use App\Models\RoomTypeImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;

class RoomTypeController extends Controller
{
    public function all(Request $request)
    {
        $user = \App\Models\User::where('id', Auth::user()->id)
        ->with('roles')
        ->with('responsible')
        ->first();

        $role_id = $user->roles[0]->id;

        if ($role_id === 4) {

            $hotelUser = DB::table('hotel_user')
            ->where('user_id', Auth::user()->id)
            ->first();
           
            $roomsType = RoomType::where('hotel_id',$hotelUser->hotel_id)->get();

            if(!$roomsType) {
                return response()->json(['error' => 'Ошибка, Нет такого типа номера'], 400);
            }
            else {
                return response(['room_types' => $roomsType], 200);
            }   
        }
        else {
            return response()->json(['error' => 'У вас нет полномочии'], 400);
        }
    }

    public function get(Request $request, $id)
    {
        $roomType = RoomType::find($id);
        $images = RoomTypeImage::where('room_type_id', $roomType->id)->get();
        return response(['room_type' => $roomType, 'images' => $images], 200);
    }
    public function add(Request $request)
    {
        
        $rules = [
            'name' => 'required|string',
            'space_size' => 'required|string',
            'description' => 'required|string',
            'hotel_id' => 'required',
            'capacity' => 'required|string',
            'room_count' => 'required|string',
            'images' => 'array',
            'hotel_id' => 'required|string'
        ];


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response($validator->failed());
        }

        
        $hotelUser = \Auth::user();
       
        if(!$hotelUser) {
            return response(['msg' => 'Не найдены отели!'], 200);
        }

        if ($room = RoomType::create($validator->validated())) {
            
            if($request->has('comfort_list')) {
                RoomType::addComfortList($room->id, $request->comfort_list);
            }
            
            $room->save();
            if ($request->hasFile('images')) {

                $files = $request->file('images');
                foreach ($files as $file) {

                    $extension = $file->getClientOriginalExtension();
                    $fileName = Str::random(20) . "." . $extension;
                    $folderpath  = 'rooms_type_images' . '/';
                    $file->move($folderpath, $fileName);
                    RoomTypeImage::create([
                        'name' => $folderpath . $fileName,
                        'room_type_id' => $room->id
                    ]);
                }

                return response(['msg' => 'Room type success added!'], 200);
            }
            return response(['msg' => 'Room type success updated!'], 200);
        }
    }

    public function editRoomType(Request $request)
    {
        $rules = [
            'id' => 'required|string',
            'name' => 'required|string',
            'space_size' => 'required|string',
            'description' => 'required|string',
            // 'comfort_list' => 'array',
            'capacity' => 'required|string',
            'room_count' => 'required|string',
            'images' => 'array',
            'hotel_id' => 'required|string'
        ];


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response($validator->failed());
        }
        if (!RoomType::find($request->id)) {
            return response(['msg' => 'Данного типа номера не существует!'], 200);
        }

        if ($room = RoomType::find($request->id)->update($validator->validated())) {
            if($request->has('comfort_list')) {
                RoomType::addComfortList($request->id, $request->comfort_list);
            }
            if ($request->hasFile('images')) {

                $files = $request->file('images');
                foreach ($files as $file) {

                    $extension = $file->getClientOriginalExtension();
                    $fileName = Str::random(20) . "." . $extension;
                    $folderpath  = 'rooms_type_images' . '/';
                    $file->move($folderpath, $fileName);
                    RoomTypeImage::create([
                        'name' => $folderpath . $fileName,
                        'room_type_id' => $request->id
                    ]);
                }
                return response(['msg' => 'Room type success updated!'], 200);
            }
            return response(['msg' => 'Room type success updated!'], 200);
        } else {
            return 'err';
        }
    }

    public function delete(Request $request)
    {

        DailyPrice::where('room_type_id',$request->id)->delete();
 
        if (RoomType::where('id', $request->id)->delete()) {
            RoomTypeImage::deleteImagesByRoomTypeId($request->id);
            return response(['msg' => 'Room type success deleted!'], 200);
        }
    }



    public function deleteImage(Request $request, $id)
    {
      
        $roomImage = RoomTypeImage::where('id',  $id)->first();

        if ($roomImage->delete()) {
            unlink(public_path() . '/' . $roomImage->name);
            return response(['msg' => 'Room image success deleted!'], 200);
        }
    }
}
