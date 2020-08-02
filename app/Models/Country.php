<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Country extends Model
{

    use LogsActivity;
    protected $guarded = [];

    protected static $logName = 'country';

    public function getDescriptionForEvent(string $eventName)
    {
        return "You have  {$eventName} country";
    }

    public function Clients() {
        return $this->hasMany(Client::class,'kato_id','id');
    }
}
