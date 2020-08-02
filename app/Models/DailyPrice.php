<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyPrice extends Model
{
    protected $table = 'daily_prices';

    public function roomType() {
        return $this->belongsTo('App\Models\RoomType');
    }
}
