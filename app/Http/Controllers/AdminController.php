<?php

namespace App\Http\Controllers;
use App\Permission_Role;
use App\Region;
use App\Role;
use App\Permission;
use App\User;
use App\UserItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions=Permission::paginate(5);
        return view('admin.permissions.index',compact('permissions'));
    }
    public function users(){
        $permissions=Permission_Role::all();
        $users_item=UserItem::all();

        $users=User::all();
        return view('admin.users',compact(['users_item','permissions','users']));

    }
    public function useredit($id){

        $regions=Region::all();
        $user=User::find($id);
        return view('admin.user.edit',compact(['user','regions']));

    }
    public function updateuser(Request $request ,$id){
        $regions=Region::find($request->region_id);
        $user=User::find($id);
        $user->name=$request->name;
        $user->email=$request->email;
        $user->region()->associate($regions);
        $user->password=bcrypt($request['password']);
        $user->save();
        return redirect()->route('showusers')->withMessage("User Updated Successfully");

    }
    public function destroyUser($id){
        User::destroy($id);
            return redirect()->route('showusers')->withMessage('User Deleted Successfully');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
      $permissions=Permission::all();
      return view('admin.permissions.create',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
