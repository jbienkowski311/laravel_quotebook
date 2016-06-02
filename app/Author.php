<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    public function quotes(){
        return $this->hasMany('App\Quote');
    }
}
