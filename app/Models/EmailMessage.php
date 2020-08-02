<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailMessage extends Model
{
    protected $table = 'email_messages';

    public function hotel()
    {
        return $this->hasOne('App\Models\Hotel');
    }
}
