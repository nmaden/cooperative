<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PaySender extends Model
{
    protected $table = "paysender";

    protected $fillable = [
        'name',
        'surname',
        'patronymic',
        'document_number',
        'date_of_given',
        'end_of_given',
        'phone',
        'iin',
        'type_agreement',
        'date_agreement'
    ];
    public static function getAll()
    {
        $paysenders = self::all();
        
        return $paysenders;
    }
    public function user() {
        return $this->belongsTo(User::class,'id','client_id');
    }

    public function prices() {
        return $this->hasMany(PayTransaction::class,'client_id','id');
    }
}
