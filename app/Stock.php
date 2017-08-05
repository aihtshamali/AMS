<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    public function region(){
        return $this->belongsTo('App\Region');
    }
    public function item(){
        return $this->belongsTo('App\Item');
    }
    public function customer(){
        return $this->belongsTo('App\Customer');
    }
}
