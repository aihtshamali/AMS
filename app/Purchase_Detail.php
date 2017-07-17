<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase_Detail extends Model
{
    public $table="Purchases_Detail";
    public function item(){
        return $this->belongsTo('App\Item');
    }
    public function purchase(){
        return $this->belongsTo('App\Purchase');
    }

}
