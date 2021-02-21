<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calculations extends Model
{
    protected $table = 'calculations';


    public function type_calculate() {
        return $this->hasMany(TypeCalculate::class,'calculation_id','id');
    }
}
