<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
     //tags - posts
     public function posts() {
        return $this->belongsToMany('App\Post');
    }
}
