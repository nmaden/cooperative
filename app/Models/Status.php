<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Status extends Model
{
    use LogsActivity;

    protected $guarded = [];

    public function Transcations()
    {
        return $this->belongsTo(Transaction::class,'id','statuses_id');
    }

    protected static $logName = 'status';
    public function getDescriptionForEvent(string $eventName)
    {
        return "You have  {$eventName} status";
    }

}
