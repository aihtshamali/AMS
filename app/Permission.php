<?php namespace App;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
   protected $fillable=['name','display_name'];
    public function permission_role(){
        return $this->belongsTo('App\Permission_Role');
    }
}
