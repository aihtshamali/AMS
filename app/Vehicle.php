<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    public function region(){
        return $this->hasOne('App\Driver');
    }
    public function transfer(){
        return $this->hasOne('App\Transfer');
    }
    public function purchase(){
        return $this->hasMany('App\Purchase');
    }

}
