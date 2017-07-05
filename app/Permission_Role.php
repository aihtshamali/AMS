<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission_Role extends Model
{
    protected $table="permission_role";
    public $timestamps = false;
    public function region(){
        return $this->belongsTo('App\Region');
    }
    public function permission(){
        return $this->belongsTo('App\Permission');
    }
}
