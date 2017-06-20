<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function region(){
        return $this->hasOne('App\Region');
    }
    public function getregion($id){
        return Region::findorFail($id);
    }
}
