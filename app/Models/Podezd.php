<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Podezd extends Model
{
    protected $table = "podezd";


    public function etaj() {
        return $this->hasMany(Etaj::class,'podezd_id','id');
    }
}
