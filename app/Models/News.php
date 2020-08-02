<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = "news";

    protected $fillable = [
        'id',
        'title',
        'description',
        'date'
    ];

    public function news_image() {
        return $this->hasMany(NewsImage::class,'news_id','id');
    }
}
