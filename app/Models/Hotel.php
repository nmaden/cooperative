<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Hotel extends Model
{

    use LogsActivity;
    protected $guarded = [];

    protected static $logName = 'hotel';
    public function getDescriptionForEvent(string $eventName)
    {
        return "You have  {$eventName} hotel";
    }

    protected $casts = [
        'show_kt' => 'boolean',
    ];

    public function responsible() {
        return $this->belongsToMany(User::class);
    }

    public function region() {
        return $this->belongsTo(Kato::class,'region_id','id');
    }
    public function area() {
        return $this->belongsTo(Kato::class,'area_id','id');
    }
    public function locality() {
        return $this->belongsTo(Kato::class,'locality_id','id');
    }

    public function actual_certifications()
    {
        return $this->hasMany(Certificate::class)
            ->where('end','>',Carbon::now())
            ->where('start','<',Carbon::now())
            ->orderBy('star','DESC');
//            ->limit(1);
    }

    public function certifications()
    {
        return $this->hasMany(Certificate::class);
    }
    
    public function Transactions() {
        return $this->hasMany(Transaction::class,'hotel_id','id');
    }
}
