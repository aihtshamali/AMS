<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function region(){
        return $this->hasOne('App\Region');
    }
    public function category(){
        return $this->hasOne('App\Category');
    }
    public function city(){
        return $this->hasOne('App\City');
    }
    public function getregion($id){
        return Region::find($id);
    }
    public function getcity($id){
        return City::find($id);
    }
}
