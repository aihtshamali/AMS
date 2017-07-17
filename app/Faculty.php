<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    public function region(){
        return $this->belongsTo('App\Region');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function transfer(){
        return $this->hasMany('App\Transfer');
    }
}
