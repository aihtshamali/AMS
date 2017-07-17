<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission_Role extends Model
{
    protected $table="permission_role";
    public $timestamps = false;
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function permission(){
        return $this->belongsTo('App\Permission');
    }
}
