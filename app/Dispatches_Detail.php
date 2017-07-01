<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dispatches_Detail extends Model
{
    protected $table="Dispatches_Detail";
    public function dispatch(){
        return $this->belongsTo('App\Dispatch');
    }
    public function customer(){
        return $this->belongsTo('App\Customer');
    }
    public function item(){
        return $this->belongsTo('App\Item');
    }

}
