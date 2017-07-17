<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    public function vehicle(){
        return $this->hasOne('App\Vehicle');
    }
    public function dispatch(){
        return $this->hasMany('App\Dispatch');
    }
    public function transfer(){
        return $this->hasMany('App\Transfer');
    }
    public function purchase(){
        return $this->hasMany('App\Purchase');
    }
}
