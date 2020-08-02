<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;

class Client extends Model
{
    use LogsActivity;
    protected $guarded = [];


    protected static $logName = 'client';
    public function getDescriptionForEvent(string $eventName)
    {
        return "You have  {$eventName} client";
    }

    /**
     * Получить гражданство клиента.
     */
    public function Citizenship()
    {
        return $this->belongsTo(Country::class,'kato_id','id');
    }
    /**
     * Получить пол клиента.
     */
    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }
    /**
     * Получить вид документа клиента.
     */
    public function doctype()
    {
        return $this->belongsTo(Doctype::class);
    }
    /**
     * Получить вид документа клиента.
     */
    public function target()
    {
        return $this->belongsTo(Target::class);
    }

    public function transactions() {
        $hotel_id = \App\Models\User::query()->where('id', Auth::id())->with('responsible')->first()->responsible->first();
        if ($hotel_id == null) {
            return $this->hasMany(Transaction::class);
        }
        else {
            return $this->hasMany(Transaction::class)->where('hotel_id',$hotel_id);
        }
    }

    public function hotel() {
        return $this->belongsTo(Hotel::class,'hotel_id','id');
    }

}
