<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function dispatch(){
        return $this->hasMany('App\Dispatches_Detail');
    }
    public function transfers_detail(){
        return $this->hasMany('App\Transfers_Detail');
    }
    public function returns_detail(){
        return $this->hasMany('App\Returns_Detail');
    }
}
