<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayTransaction extends Model
{
    protected $table = "paytransaction";

    protected $fillable = [
        'client_id',
        'amount',
        'type_of_transaction',
        'street_of_bank',
        'date_of_transaction'
    ];
    public static function getAll()
    {
        $paytransactions = self::all();
       
        return $paytransactions;
    }

    public function user() {
        return $this->belongsTo(User::class,'id','id');
    }
}
