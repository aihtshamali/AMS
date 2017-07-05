<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    public function city(){
        return $this->belongsTo('App\City');
    }
    public function transfers_detail(){
        return $this->hasMany('App\Transfers_Detail');
    }
    public function returns_detail(){
        return $this->hasMany('App\Returns_Detail');
    }
    public function cutomer(){
        return $this->hasMany('App\Customer');
    }
    public function dispatch(){
        return $this->hasMany('App\Dispatch');
    }
    public function user(){
        return $this->hasMany('App\User');
    }
    public function permission_role(){
        return $this->hasMany('App\Permission_Role');
    }
    public function item(){
        return $this->hasMany('App\Item');
    }
}

