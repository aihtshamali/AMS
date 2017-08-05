<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Permission_Role;
use App\User;
use Illuminate\Http\Request;

class UserPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::paginate(5);
        return view('admin.userspermission',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user=User::find($request->user_id);
        foreach ($request->userpermission as $perm){
            $userpermission=new Permission_Role();
            $permission=Permission::find($perm);
            $userpermission->permission()->associate($permission);
            $userpermission->user()->associate($user);
            $userpermission->save();
        }
        return redirect()->back()->withMessage("Roles Added Successffuly");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//        dd($id);
        $permissions= Permission_Role::where('user_id',$id)->paginate(8);
        $userpermissions=Permission_Role::where('user_id',$id)->get();
        $user=User::find($id);
        $allpermission=Permission::all();
        return view('admin.userpermission.edit',compact(['permissions','user','allpermission','userpermissions']));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Permission_Role::destroy($id);
        return redirect()->back()->withMessage('Role Detached from User Successfully ');
    }
}
