<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Returns_Detail extends Model
{
    protected $table="return_Details";

    public function returns(){
        return $this->belongsTo('App\Returns');
    }
    public function region(){
        return $this->belongsTo('App\Region');
    }
    public function item(){
        return $this->belongsTo('App\Item');
    }
}
