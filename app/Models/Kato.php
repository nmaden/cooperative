<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Kato extends Model
{
    use LogsActivity;

    protected $guarded = [];

    protected static $logName = 'kato';
    public function getDescriptionForEvent(string $eventName)
    {
        return "You have  {$eventName} kato";
    }
    public function hotel_region() {
        return $this->hasMany(Hotel::class,'region_id','id');
    }
}
