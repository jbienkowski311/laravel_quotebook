<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    public function author(){
        return $this->belongsTo('App\Author');
    }

    public function users(){
        return $this->belongsToMany('App\User', 'user_quote');
    }
}
