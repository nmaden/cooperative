<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Transaction extends Model
{
    use LogsActivity;

    protected $guarded = [];

    protected static $logName = 'transaction';

    public static $logAttributes = ['number','check_in','check_out','start_check_date','end_check_date','hotel_id','status_id'];
    
    public function getDescriptionForEvent(string $eventName)
    {
        $user = User::where('id', '=', Auth::id())
        ->with('roles')
        ->with('responsible')
        ->first();
      
        return $user->surname.' '.$user->name." добавил(-а) новый лист прибытия";
        
        
    }

    public function client() {
        return $this->belongsTo(Client::class,'client_id','id');
    }
    public function status() {
        return $this->belongsTo(Status::class,'statuses_id','id');
    }

    public function hotel() {
        return $this->belongsTo(Hotel::class,'hotel_id','id');
    }
}
