<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Doctype extends Model
{
    
    use LogsActivity;
    protected $guarded = [];

    protected static $logName = 'doctype';
    public function getDescriptionForEvent(string $eventName)
    {
        return "You have  {$eventName} doctype";
    }
}
