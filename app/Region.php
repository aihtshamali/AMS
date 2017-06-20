<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    public function city(){
        return $this->belongsTo('App\City');
    }
    public function cutomer(){
        return $this->hasMany('App\Customer');
    }
}

