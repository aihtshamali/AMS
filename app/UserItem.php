<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserItem extends Model
{
     public $timestamps=false;
//    protected $table="useritems";
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function item(){
        return $this->belongsTo('App\Item');
    }
}
