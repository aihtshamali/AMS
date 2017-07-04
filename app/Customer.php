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
    public function transfers_detail(){
        return $this->hasMany('App\Transfers_Detail');
    }
    public function returns_detail(){
        return $this->hasMany('App\Returns_Detail');
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
