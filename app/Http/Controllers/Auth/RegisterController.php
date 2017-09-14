<?php

namespace App\Http\Controllers\Auth;

use App\Permission;
use App\Permission_Role;
use App\Region;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/users';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','acl']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'region'=>'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {

        $users= new User();
        $users->name=$data['name'];
        $users->email=$data['email'];
        $users->password=bcrypt($data['password']);
        $users->region()->associate($data['region']);
        $users->save();
        $allowedPermissions=['logout','login','welcome','home','unauthorized'];
        for($i=0;$i<count($allowedPermissions);$i++) {
            $per = Permission::where('name',$allowedPermissions[$i])->first();
            $perm = new Permission_Role();
            $perm->user()->associate($users);
            $perm->permission()->associate($per);
            $perm->save();
        }
        return $users;
    }
}
