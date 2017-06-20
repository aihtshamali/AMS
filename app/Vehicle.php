<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    public function region(){
        return $this->hasOne('App\Driver');
    }

}
