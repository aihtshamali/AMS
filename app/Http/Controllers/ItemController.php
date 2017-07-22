<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $items= Item::paginate(7);
       return view('item.index',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('item.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = new Item();
        $item->code= $request->code;
        $item->name= $request->name;
        $item->display_name= $request->display_name;
        $item->item_group= $request->item_group;
        $item->for_customer= $request->for_customer;
        $item->department= $request->department;
        $item->color= $request->color;
        $item->is_active= $request->is_active;
        $item->save();
        return redirect()->route('item.index')->withMessage('Item Inserted Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item= Item::find($id);
        return view('item.edit',compact('item'));
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
        Item::find($id)->delete();
        $item = new Item();
        $item->code= $request->code;
        $item->name= $request->name;
        $item->display_name= $request->display_name;
        $item->item_group= $request->item_group;
        $item->for_customer= $request->for_customer;
        $item->department= $request->department;
        $item->color= $request->color;
        $item->is_active= $request->is_active;
        $item->save();
        return redirect()->route('item.index')->withMessage('Item Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Item::find($id)->delete();
        return redirect()->route('item.index')->withMessage('Item Deleted Successfully');

    }
}
