<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable,HasRoles,LogsActivity;

    protected $guarded = [];


    protected static $logAttributes = ['name','email','surname','iin','avatar'];

    protected static $logName = 'user';
    
    public function getDescriptionForEvent(string $eventName)
    {   
       
    }

    protected $hidden = [
        'password', 'remember_token',
    ];



    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hotels() {
        return $this->belongsToMany(Hotel::class);
    }

    public function responsible() {
        return $this->belongsToMany(Hotel::class);
    }

    public function hotel() {
        return $this->hasOne('App\Models\Hotel');
    }
}
