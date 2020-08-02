<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Target extends Model
{
    use LogsActivity;

    protected $guarded = [];

    protected static $logName = 'target';
    public function getDescriptionForEvent(string $eventName)
    {
        return "You have  {$eventName} target";
    }
}
