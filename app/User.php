<?php

namespace App;

use Notifiables;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    public function permission_role(){
        return $this->hasMany('App\Permission_Role');
    }

//        use EntrustUserTrait; // add this trait to your user model
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function region(){
        return $this->belongsTo('App\Region');
    }
    public function  useritem(){
        return $this->hasMany('App\UserItem');
    }
    public function faculty(){
        return $this->hasMany('App\Faculty');
    }
    public function purchase(){
        return $this->hasMany('App\Purchase');
    }
}
