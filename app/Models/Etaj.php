<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etaj extends Model
{
    protected $table = "etaj";

  
    public function kvartira() {
        return $this->hasMany(Kvartira::class,'etaj_id','etaj');
    } 
}
