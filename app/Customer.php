<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'id',
        'account_no',
        'account_name',
        'customer_group',
        'city_id',
        'region_id',
    ];
    public function region(){
        return $this->belongsTo('App\Region');
    }
    public function dispatches_detail(){
        return $this->hasMany('App\Dispatches_Detail');
    }
    public function transfer(){
        return $this->hasMany('App\Transfer');
    }
    public function stock(){
        return $this->hasMany('App\Stock');
    }
    public function returns_detail(){
        return $this->hasMany('App\Returns_Detail');
    }

    public function city(){
        return $this->belongsTo('App\City');
    }
    public function getregion($id){
        return Region::find($id);
    }
    public function getcity($id){
        return City::find($id);
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
