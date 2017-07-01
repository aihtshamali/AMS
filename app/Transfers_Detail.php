<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfers_Detail extends Model
{
    protected $table="transfer_details";
    public function transfer(){
        return $this->belongsTo('App\Transfer');
    }
    public function region(){
        return $this->belongsTo('App\Region');
    }
    public function item(){
        return $this->belongsTo('App\Item');
    }
}
