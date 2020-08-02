<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Gender extends Model
{
    use LogsActivity;
    protected $guarded = [];

    protected static $logName = 'gender';
    public function getDescriptionForEvent(string $eventName)
    {
        return "You have  {$eventName} gender";
    }
}
