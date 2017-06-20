<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dispatch extends Model
{
    public function driver(){
        return $this->hasMany('App\Driver');
    }
    public function vehicle(){
        return $this->hasMany('App\Vehicle');
    }
}
