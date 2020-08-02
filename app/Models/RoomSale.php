<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomSale extends Model
{
    protected $table = "room_sales";

    protected $fillable = [
        'room_type_id', 'count', 'tarif_id',
        'booked_count', 'date'
    ];
}
