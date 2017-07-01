<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    public function getregion($id){
        return Region::find($id);
    }
    public function getcity($id){
        return City::find($id);
    }
    public function dispatches_detail(){
        return $this->hasMany('App\Dispatches_Detail');
    }
    public function transfer(){
        return $this->hasMany('App\Transfer');
    }
    public function returns(){
        return $this->hasMany('App\Returns');
    }








//    public function region(){
//        return $this->hasOne('App\Region');
//    }
//    public function category(){
//        return $this->hasOne('App\Category');
//    }
//    public function city(){
//        return $this->hasOne('App\City');
//    }
}
