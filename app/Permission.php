<?php namespace App;

use Illuminate\Database\Eloquent\Model;
//use Zizaco\Entrust\EntrustPermission;

class Permission extends Model
{
   protected $fillable=['name','display_name'];
    public function permission_role(){
        return $this->hasMany('App\Permission_Role');
    }
}
