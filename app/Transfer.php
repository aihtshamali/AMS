<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    public function customer(){
        return $this->belongsTo('App\Customer');
    }
    public function transfers_detail(){
        return $this->hasMany('App\Transfers_Detail');
    }
}
