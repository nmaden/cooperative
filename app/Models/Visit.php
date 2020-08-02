<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Visit extends Model
{
    
    use LogsActivity;

    protected $guarded = [];

    protected static $logName = 'visit';
    public function getDescriptionForEvent(string $eventName)
    {
        return "You have  {$eventName} visit";
    }
}
