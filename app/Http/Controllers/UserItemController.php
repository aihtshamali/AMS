<?php

namespace App\Http\Controllers;

use App\Item;
use App\User;
use App\UserItem;
use Illuminate\Http\Request;

class UserItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $useritems=UserItem::all();
        return view('admin.useritems.index',compact('useritems'));
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
        $user= User::find($request->user_id);
        foreach ($request->useritems as $useritem){
            $Nuseritem=new UserItem();
            $item=Item::find($useritem);
            $Nuseritem->user()->associate($user);
            $Nuseritem->item()->associate($item);
            $Nuseritem->save();
        }
        return redirect()->back()->withMessage("Item Attached Successfully");
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
        $items=Item::all();
        $user_items=UserItem::where('user_id',$id)->get();
        $user=User::find($id);
        return view('admin.useritems.edit',compact(['items','user_items','user']));
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
        UserItem::destroy($id);
        return redirect()->back()->withMessage('Item detached Successfully');
    }
}
