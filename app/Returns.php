<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Returns extends Model
{
    protected $table="returns";


    public function returns_detail(){
        return $this->hasMany('App\Returns_Detail');
    }
}
