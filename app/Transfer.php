<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{

    public function transfers_detail(){
        return $this->hasMany('App\Transfers_Detail');
    }
    public function customer(){
        return $this->belongsTo('App\Customer');
    }
    public function driver(){
        return $this->belongsTo('App\Driver');
    }public function faculty(){
        return $this->belongsTo('App\Faculty');
    }
    public function vehicle(){
        return $this->belongsTo('App\Vehicle');
    }
    public function getFaculty($id){
        return Faculty::find($id);
    }
    public function countTransferDetails($id){
        return count(Transfers_Detail::where('transfer_id',$id)->get());
    }
    public function getRegion($id){
        return Transfers_Detail::where('transfer_id',$id)->first();
    }
}
