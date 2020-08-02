<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomTypeImage extends Model
{
    protected $table = 'room_types_images';
    protected $fillable = ['name', 'room_type_id'];


    public static function deleteImagesByRoomTypeId($id)
    {
        $images = self::where('room_type_id', $id)->get();

        foreach($images as $image) {
            $image->delete();
            unlink(public_path() . '/' . $image->name);
        }
    }
}
