<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KenesOrder extends Model
{
    protected $table = 'orders_kenes';


    public function ordered_elements() {
        return $this->hasMany(OrderedElements::class,'order_id','id');
    }
}
