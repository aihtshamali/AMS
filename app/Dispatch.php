<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dispatch extends Model
{
    public function dispatches_detail(){
        return $this->hasMany('App\Dispatches_Detail');
    }
    public function driver(){
        return $this->belongsTo('App\Driver');
    }
    public function region(){
        return $this->belongsTo('App\Region');
    }








//    public function vehicle(){
//        return $this->hasMany('App\Vehicle');
//    }

}
