<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Certificate extends Model
{
    use LogsActivity;
    protected $guarded = [];

    
    protected static $logName = 'certificate';

    public function getDescriptionForEvent(string $eventName)
    {
        return "You have  {$eventName} certificate";
    }

    public function hotel() {
        return $this->belongsTo(Hotel::class,'hotel_id','id');
    }
}
