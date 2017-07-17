<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
   public function region(){
       return $this->belongsTo('App\Region');
   }
    public function driver(){
        return $this->belongsTo('App\Driver');
    }
    public function vehicle(){
        return $this->belongsTo('App\Vehicle');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function purchase_detail(){
        return $this->hasMany('Purchase_Detail');
    }
}
