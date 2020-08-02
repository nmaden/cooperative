<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $table = 'hotel_room_types';
    protected $fillable = [
        'name', 'space_size', 'description',
        'capacity', 'room_count', 'comfort_list','hotel_id'
    ];


    public static function getAll()
    {
        $rooms = self::all();
        foreach ($rooms as $room) {
            $room->images = RoomTypeImage::where('room_type_id', $room->id)->get();
        }
        return $rooms;
    }

    public function dailyPrice()
    {
        return $this->hasMany('\App\Models\DailyPrice')->orderBy('date');
    }

    public static function addComfortList($id, $comfortList)
    {
        self::where('id', $id)->update(['comfort_list' => implode('&', $comfortList)]);
    }

}
