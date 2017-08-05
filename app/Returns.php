<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Returns extends Model
{
    protected $table="returns";

    public function countReturnDetails($id){
        return count(Returns_Detail::where('returns_id',$id)->get());
    }
    public function returns_detail(){
        return $this->hasMany('App\Returns_Detail');
    }
    public function getFaculty($id){
        return Faculty::find($id);
    }
    public function getCustomer($id){
        return Returns_Detail::where('returns_id',$id)->first();
    }
}
