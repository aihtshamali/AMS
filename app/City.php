<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable=[
        'id',
        'name',
        'description',
        'region_id',
        ];
    public function region(){
        return $this->belongsTo('App\Region');
    }
    public function getregion($id){
        return Region::findorFail($id);
    }
    public function customer(){
        return $this->hasMany('App\Customer');
    }

}
